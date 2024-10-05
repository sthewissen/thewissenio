---
layout: post
title: Building a .NET MAUI CD pipeline in GitHub Actions (Part I - Main)
date: '2023-09-28 18:45:00 +0000'
image: '/images/headers/pipeline.jpg'
categories: Code
tags: maui continuous-delivery github-actions
---

In this first post I look to cover building a GitHub Actions pipeline that can build your .NET MAUI application for both Android and iOS and get it all the way to the Google Play Store and Apple AppStore for testing. To do so, we'll be using nested workflows for both of these different platforms, which are called from a root workflow. This post will cover the overarching workflow while next installments will cover the iOS and Android side of things. Let's break it down!

## The parent workflow

Each GitHub Actions workflow starts with the definition of when it should be executed. This section outlines the conditions that trigger your workflow. In this case you can trigger this workflow manually through the GitHub Actions UI. Whenever there's a push to the main branch, the workflow kicks in, unless the changes only affect certain files. It also responds to pull requests targeting the main branch.

```yaml
name: CD Build

on:
  workflow_dispatch:
  push:
    branches: [ "main" ]
    paths-ignore:
      - "**.md"
      - '**/*.gitignore'
      - '**/*.gitattributes'
      - '**/*.yml'
  pull_request:
    branches: [ "main" ]
```

The following part defines essential environment variables for your workflow. These variables hold configuration information for your workflow:

- **BUILD_VERSION:** Specifies the app version as '1.0'.
- **DOTNET_VERSION:** Sets the .NET version to '7.0.x'.
- **XCODE_VERSION:** Defines the Xcode version for our build as '14.3'.
- **DOTNET_VERSION_TARGETS:** Used as input for MSBuild to take the right target.
- **CSPROJ_TO_BUILD:** Specifies the path to your project file.
- **PROJECT_FOLDER:** Defines the folder name for your project.

```yaml
env:
  BUILD_VERSION: '2.0'
  DOTNET_VERSION: 7.0.x
  XCODE_VERSION: 14.3
  DOTNET_VERSION_TARGETS: net7.0
  CSPROJ_TO_BUILD: PATH_TO_PROJECT_FILE
  PROJECT_FOLDER: PROJECT_FOLDER_NAME
```

Due to limitations in the nested workflows infrastructure, we cannot access environment variables from a nested workflow. The solution around that is to create a separate job that takes those environment variables and creates outputs for them. These outputs can then be passed down into the subsequent Android and iOS builds to be used there.

```yaml
{% raw %}
jobs:
  vars:
    runs-on: ubuntu-22.04
    outputs:      
      buildVersion: ${{ env.BUILD_VERSION }}
      dotnetVersion: ${{ env.DOTNET_VERSION }}
      xcodeVersion: ${{ env.XCODE_VERSION }}
      dotnetVersionTargets: ${{ env.DOTNET_VERSION_TARGETS }}
      csprojToBuild: ${{ env.CSPROJ_TO_BUILD }}
      projectFolder: ${{ env.PROJECT_FOLDER }}
    steps:
      - run: echo "Exposing env vars, because they can't be passed to nested workflows."
{% endraw %}
```

## Calling the iOS workflow

This section defines an iOS-specific subjob. It depends on the the aforementioned 'vars' job. It specifies the necessary inputs, secrets, and configurations for building iOS applications.

```yaml
{% raw %}
build-ios:   
    needs: vars 
    uses: ./.github/workflows/cd-ios.yml
    with:
      dotnet-version: ${{ needs.vars.outputs.dotnetVersion }}
      dotnet-version-target: ${{ needs.vars.outputs.dotnetVersionTargets }}
      xcode-version: ${{ needs.vars.outputs.xcodeVersion }}
      project-file: ${{ needs.vars.outputs.csprojToBuild }}
      project-folder: ${{ needs.vars.outputs.projectFolder }}
      build-config: 'Release'
      build-version: ${{ needs.vars.outputs.buildVersion }}
    secrets:
      p12-cert: ${{ secrets.CERTIFICATES_P12 }}
      p12-cert-password: ${{ secrets.CERTIFICATES_P12_PASSWORD }}
      appstore-issuer: ${{ secrets.APPSTORE_ISSUER_ID }}
      appstore-keyid: ${{ secrets.APPSTORE_KEY_ID }}
      appstore-private-key: ${{ secrets.APPSTORE_PRIVATE_KEY }}
{% endraw %}
```

This subjob depends on the `vars` job and uses an external workflow definition from the `cd-ios.yml` YAML file, which will be covered in a future blog post. It passes a set of input variables and secrets required for building an iOS application, including version information, file paths, and security credentials. This separation of concerns helps maintain a clean and modular workflow configuration.

The most interesting part here is the reference to the P12 certificate used for signing. This certificate can be set up in the Apple Developer Portal and needs to be added as a secret to the GitHub project. However, GitHub Secrets doesn't accept files. This means we have to somehow get this file in there as a string. Luckily we can use the following command-line command for that!

```bash
base64 CertificateFile.p12 | pbcopy
```

Paste the output of the above command into a secret called `CERTIFICATES_P12` and the password into `CERTIFICATES_P12_PASSWORD` into the GitHub Actions Secrets in the GitHub settings. If you want to directly publish your app to the AppStore Connect Portal from the GitHub Action you will also need to find your Issuer ID and paste that into a `APPSTORE_ISSUER_ID` secret. You can find this information [here](https://appstoreconnect.apple.com/access/api) when logged into your Developer Account (the Issuer ID will be different for each Developer Account you are a part of) and your Team Agent has enabled this functionality.

## Calling the Android workflow

This section defines an Android-specific subjob. It depends on the the aforementioned 'vars' job. It specifies the necessary inputs, secrets, and configurations for building Android applications.

```yaml
{% raw %}
  build-android:
    needs: vars
    uses: ./.github/workflows/cd-android.yml
    with:
      dotnet-version: ${{ needs.vars.outputs.dotnetVersion }}
      dotnet-version-target: ${{ needs.vars.outputs.dotnetVersionTargets }}
      project-file: ${{ needs.vars.outputs.csprojToBuild }}
      project-folder: ${{ needs.vars.outputs.projectFolder }}
      build-config: 'Release'
      build-version: ${{ needs.vars.outputs.buildVersion }}
    secrets:
      keystore: ${{ secrets.PLAY_KEYSTORE }}
      keystore-alias: ${{ secrets.PLAY_KEYSTORE_ALIAS }}
      keystore-password: ${{ secrets.PLAY_KEYSTORE_PASS }}
      playstore-service-account: ${{ secrets.PLAYSTORE_SERVICE_ACC }}
{% endraw %}
```

Most interesting here are the `PLAY_KEYSTORE` and it's `PLAY_KEYSTORE_ALIAS` and `PLAY_KEYSTORE_PASS` secrets. The same applies as before when it comes to the actual keystore file not being compatible with a GitHub secret. In this case, we once again encode it as Base64, but in a way that we can re-construct it later in our pipeline. To do so, we use the following command-line command:

```bash
openssl base64 < MYKEYSTORE.jks | tr -d '\n' | tee MYKEYSTORE_BASE64.txt
```

This will output a file that has your keystore as a base64 string in it. Copy this into the `PLAY_KEYSTORE` secret and provide the alias and password you created when the keystore was originally set up. That concludes setting up the overarching pipeline definition. In the next post we will dive deeper into the nitty-gritty details of setting up the iOS pipeline.


## More in this series

- [Building a .NET MAUI CD pipeline in GitHub Actions (Part I - Main)](https://thewissen.io/making-maui-cd-pipeline/) (this post)
- [Building a .NET MAUI CD pipeline in GitHub Actions (Part II - iOS)](https://thewissen.io/making-maui-cd-pipeline-part2/)
- [Building a .NET MAUI CD pipeline in GitHub Actions (Part III - Android)](https://thewissen.io/making-maui-cd-pipeline-part3/)