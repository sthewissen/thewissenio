---
layout: post
title: Building a .NET MAUI CD pipeline in GitHub Actions (Part II)
date: '2023-10-23 11:45:42 +0000'
image: '/images/headers/pipeline2.jpg'
categories: Code
tags: maui continuous-delivery github-actions
---

Welcome to the second post covering building a GitHub Actions pipeline that can build your .NET MAUI application for both Android and iOS. This time around we're going to take a look at the iOS specific pipeline, which gets your app binary all the way to the Apple AppStore for testing. In [my previous article](https://www.thewissen.io/making-maui-cd-pipeline/) I set up a parent workflow that passes a bunch of parameters and secrets down into the iOS specific pipeline. If you haven't read that article yet, read it before proceeding to read this one. Done reading it? Then let's start!

## The initial workflow initialization
Our first step is to take all the incoming variables and define them in our nested workflow. That way we can use them in the next steps. The same goes for the secrets. We define both of these at the start of our workflow in the `workflow_call` node by defining them with both a type and name.

```yaml
{% raw %}
name: iOS Publish

on:
  workflow_call:
    inputs:
      dotnet-version:
        required: true
        type: string
      dotnet-version-target:
        required: true
        type: string
      xcode-version:
        required: true
        type: string
      project-file:
        required: true
        type: string
      project-folder:
        required: true
        type: string
      build-config:
        required: true
        type: string
      build-version:
        required: true
        type: string
    secrets:      
      p12-cert:
        required: true
      p12-cert-password:
        required: true
      appstore-issuer:
        required: true
      appstore-keyid:
        required: true
      appstore-private-key:
        required: true
{% endraw %}
```

Subsequently we tell our pipeline that we want to run this publishing job on a macOS machine. In this case, we're using `macos-13` but you can also use `macos-latest` to get all the most up-to-date versions of the tooling. However, depending on your codebase it can be benificial to use an earlier version of the build agent to get your project build up-and-running. 

```yaml
{% raw %}
jobs:
  publish-ios:
    runs-on: macos-13
    name: iOS Publish

    steps:
      ...
{% endraw %}
```

## Setting up for a successful build

These steps collectively set up the development environment, install necessary tools, and prepare the project for subsequent actions like building, testing, or deploying. It sets the version of Xcode to use, the .NET version to use, checks out the code, installs the necessary .NET MAUI workloads and restores any additional external dependencies the project might have.

```yaml
{% raw %}
  - uses: maxim-lobanov/setup-xcode@v1
    name: Set XCode version
    with:
      xcode-version: ${{ inputs.xcode-version }}

  - name: Setup .NET ${{ inputs.dotnet-version }}
    uses: actions/setup-dotnet@v2
    with:
      dotnet-version: ${{ inputs.dotnet-version }}

  - uses: actions/checkout@v3
    name: Checkout the code

  # This step might be obsolete at some point as .NET MAUI workloads 
  # are starting to come pre-installed on the GH Actions build agents.
  - name: Install MAUI Workload
    run: dotnet workload install maui --ignore-failed-sources

  - name: Restore Dependencies
    run: dotnet restore ${{ inputs.project-file }}
{% endraw %}
```

## Setting up the iOS-specifics

The next step is setting up our environment for code signing through Apple's toolchain. We start by importing code-signing certificates into the build environment. These certificates are used for code-signing iOS or macOS applications. They are passed in through the parent pipeline. The next step essentially uses the provided parameters to authenticate with Apple's servers, query and download the necessary provisioning profiles, used for signing and deploying iOS applications. These profiles are essential for ensuring that the application can be distributed and run on Apple devices.

```yaml
{% raw %}
  # These expire on a yearly basis, so check if they're still valid!
  - uses: apple-actions/import-codesign-certs@v2
    with: 
      p12-file-base64: ${{ secrets.p12-cert }}
      p12-password: ${{ secrets.p12-cert-password }} 

  - name: Download Provisioning Profiles
    id: provisioning
    uses: apple-actions/download-provisioning-profiles@v1
    with: 
      bundle-id: ${{ inputs.package-name }}
      profile-type: 'IOS_APP_STORE'
      issuer-id: ${{ secrets.appstore-issuer }}
      api-key-id: ${{ secrets.appstore-keyid }}
      api-private-key: ${{ secrets.appstore-private-key }}
{% endraw %}
```

## Version the app

This step helps manage the version information of a .NET MAUI application. The `csproj` parameter should be pointing to the actual path of the project file, and the `version` parameter should be set to an internal numerical value that ensures the uniqueness of the application's version. Each version of a binary that you upload to Apple's portal should have a subsequent higher version number. The `displayVersion` parameter adds additional information to the version representing an easier to understand version number, and the `printFile`` parameter is optional and can be used to log the version that is eventually used if set to true.

```yaml
{% raw %}
  - name: Version the app
    uses: managedcode/MAUIAppVersion@v1
    with: 
      csproj: ${{ inputs.project-file }}
      version: ${{ github.run_number }} # to keep value unique
      displayVersion: ${{ inputs.build-version }}.${{ github.run_number }}
      printFile: true # optional 
{% endraw %}
```

## Publishing the app

The next step essentially uses the `dotnet publish` command to build and publish the iOS app. We provide the project file, type of build configuration and the framework we want to build for (iOS). By telling the `publish` command to also `ArchiveOnBuild` we indicate that we want to have an IPA file at the end of this step. This IPA file can then be used to upload to TestFlight.

```yaml
{% raw %}
  - name: Publish the iOS app
    run: dotnet publish ${{inputs.project-file}} -c ${{ inputs.build-config }} -f:${{ inputs.dotnet-version-target }}-ios /p:ArchiveOnBuild=true /p:EnableAssemblyILStripping=false
{% endraw %}
```               

## Uploading to TestFlight
Last but definitely not least, we need to upload the IPA file we got from the previous step into Apple's TestFlight platform. In the previous post we've set up API keys to connect to this platform that are being passed into this nested workflow. We pass in the path to where the `dotnet publish` command has published the IPA file along with the API keys and other data we got from the TestFlight platform. In the previous post in our series I detailed how to set this initial connection up.

```yaml
{% raw %}
  - name: Upload app to TestFlight
    uses: apple-actions/upload-testflight-build@v1
    with:
      app-path: ${{ github.workspace }}/${{ inputs.project-folder }}/bin/${{ inputs.build-config }}/${{ inputs.dotnet-version-target }}-ios/ios-arm64/publish/${{ inputs.project-folder }}.ipa
      issuer-id: ${{ secrets.appstore-issuer }}
      api-key-id: ${{ secrets.appstore-keyid }}
      api-private-key: ${{ secrets.appstore-private-key }}
{% endraw %}
```

And that's it! In this article I tried to provid an in-depth look at the GitHub Actions workflow steps required for building a .NET MAUI application specifically for iOS. The final step ensures seamless integration with Apple's TestFlight platform for testing and distribution. If you have any questions, don't hesitate to reach out to me on social media.

## More in this series

- [Building a .NET MAUI CD pipeline in GitHub Actions (Part I)](https://thewissen.io/making-maui-cd-pipeline/)
- [Building a .NET MAUI CD pipeline in GitHub Actions (Part II)](https://thewissen.io/making-maui-cd-pipeline-part2/) (this post)