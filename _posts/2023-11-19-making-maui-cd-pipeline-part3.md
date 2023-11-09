---
layout: post
title: Building a .NET MAUI CD pipeline in GitHub Actions (Part III - Android)
date: '2023-11-19 14:48:59 +0000'
image: '/images/headers/pipeline3.jpg'
categories: Code
tags: maui continuous-delivery github-actions
---

This is the third and last post covering how to build a GitHub Actions pipeline and have it build your .NET MAUI application for both Android and iOS. In this last installment we're going to take a look at the Android specific pipeline getting your app all the way to the Google Play Store. In [the first article](https://www.thewissen.io/making-maui-cd-pipeline/) of this series I set up a parent workflow that passes parameters and secrets down into the Android specific pipeline we'll be creating here. Be sure to give that one a read before continuing to read this one!

## The initial workflow initialization
Our first step is to take all the incoming variables and define them in our nested workflow. That way we can use them in the next steps. The same goes for the secrets. We define both of these at the start of our workflow in the `workflow_call` node by defining them with both a type and name.

```yaml
{% raw %}
name: Android Publish

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
      keystore-password:
        required: true
      keystore-alias:
        required: true
      keystore:
        required: true
      playstore-service-account:
        required: true
{% endraw %}
```

Afterward, we specify to our pipeline that we intend to execute this publishing task on a Windows machine. We employ windows-latest in this scenario to ensure we have access to the latest tooling versions. Nevertheless, depending on the nature of your codebase, it might be advantageous to opt for an earlier version of the build agent in order to successfully set up your project build.

```yaml
{% raw %}
jobs:
  publish-android:
    runs-on: windows-latest
    name: Android Publish

    steps:
      ...
{% endraw %}
```

## Setting up for a successful build

These steps collectively set up the development environment, install necessary tools, and prepare the project for subsequent actions like building, testing, or deploying. It sets the .NET version to use, checks out the code, installs the necessary .NET MAUI workloads and restores any additional external dependencies the project might have.

```yaml
{% raw %}
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

## Setting up the Android-specifics

The following task involves configuring our environment for code signing using Google's toolchain. This process commences with the decoding of the keystore file from our secrets and transferring it into the build environment. This keystore plays a crucial role in signing your Android app and is provided via the parent pipeline. To ensure proper functionality, the file must reside on the build agent's filesystem rather than being stored within the pipeline's secrets. Hence, the reason we are currently placing it in that location.

```yaml
{% raw %}
  - name: Decode Keystore
    id: decode_keystore
    uses: timheuer/base64-to-file@v1
    with:
      fileDir: '${{ github.workspace }}\${{ inputs.project-folder }}'
      fileName: 'ourkeystore.jks'
      encodedString: ${{ secrets.keystore }}
{% endraw %}
```

## Version the app

This stage facilitates the management of version information for a .NET MAUI application. The `csproj` parameter should be directed to the specific location of the project file, while the `version` parameter should be configured with an internal numerical value to guarantee the uniqueness of the application's version. Each binary version uploaded to Google's portal should have a sequentially higher version number. The `displayVersion` parameter introduces supplementary information to the version, making it more user-friendly. The `printFile` parameter is optional and can be employed to log the version that is ultimately utilized when set to true.

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

In the subsequent step, we primarily utilize the `dotnet publish` command to both build and publish the Android app. This operation involves specifying the project file, the desired build configuration, and the target framework for Android. By instructing the `publish` command to utilize a keystore and providing the path to the keystore previously downloaded to the build agent, we signal our intent to sign this binary. To accomplish this, we also provide the alias and password set during the keystore's creation, which is not elaborated upon in this article.

```yaml
{% raw %}
  - name: Publish MAUI Android AAB
    run: dotnet publish ${{inputs.project-file}} -c ${{ inputs.build-config }} -f ${{ inputs.dotnet-version-target }}-android /p:AndroidPackageFormats=aab /p:AndroidKeyStore=true /p:AndroidSigningKeyStore=ourkeystore.jks /p:AndroidSigningKeyAlias=${{secrets.keystore-alias}} /p:AndroidSigningKeyPass="${{ secrets.keystore-password }}" /p:AndroidSigningStorePass="${{ secrets.keystore-password }}" --no-restore
{% endraw %}
```               

## Uploading to Google Play Console
The final, and certainly critical, step involves uploading the AAB file obtained in the previous step to Google's Play Console platform. This is accomplished by setting up a service account within the Play Console, the information of which can then be exported as a JSON file. This JSON file serves as the secret passed into this nested workflow. Within this last step, we provide this JSON info, the path to where the AAB file was published by the dotnet publish command, along with any other relevant data to push our package into the Google Play Console.

```yaml
{% raw %}
  - uses: r0adkll/upload-google-play@v1.0.17
    name: Upload Android Artifact to Play Console
    with:
      serviceAccountJsonPlainText: ${{ secrets.playstore-service-account }}
      packageName: ${{ inputs.package-name }}
      releaseFiles: ${{ github.workspace }}\${{ inputs.project-folder }}\bin\${{ inputs.build-config }}\${{ inputs.dotnet-version-target }}-android\${{ inputs.package-name }}-Signed.aab
      track: internal
{% endraw %}
```

And that concludes our look at the pipeline! In this article, I aimed to offer a comprehensive overview of the GitHub Actions workflow steps necessary for building a .NET MAUI application, with a particular focus on Android. The last step in the workflow ensures a smooth integration with Google's Play Console platform for testing and distribution. If you have any questions, please feel free to contact me via social media.

## More in this series

- [Building a .NET MAUI CD pipeline in GitHub Actions (Part I - Main)](https://thewissen.io/making-maui-cd-pipeline/)
- [Building a .NET MAUI CD pipeline in GitHub Actions (Part II - iOS)](https://thewissen.io/making-maui-cd-pipeline-part2/)
- [Building a .NET MAUI CD pipeline in GitHub Actions (Part III - Android)](https://thewissen.io/making-maui-cd-pipeline-part3/) (this post)