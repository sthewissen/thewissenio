---
layout: post
title: Uninstalling a stubborn Windows 8.1 app
date: '2015-03-19 17:14:00 +0100'
categories:
- Code
tags:
- ".net"
---

Today we came across the issue that one of our customers' IT specialists received a strange message while trying to install a new build of one of our apps.

He was installing the app on a Windows 8.1 tablet using side-loading, but the installer said that an app with the same ID was already installed. The user mentioned he had uninstalled the previous version(s) as he had done with 10+ other tablets but this particalur one was giving him a headache. The message itself wasn't really clear though. It just said that an app (identified by a guid, a version number and some additional mumbo jumbo) matching the app he was trying to install was already installed and would need to be uninstalled first. Seeing as how there was no trace of any remnants of the uninstall it was time for me to dive under the hood and see what was going on. Step one: start PowerShell (as an administrator).

### Finding the troublesome app

Let's start by searching which app is giving us a headache. This is done by entering the `Get-AppxPackage` command. This gives you a list of all the apps that are currently installed. This is likely to be quite a long list. Somewhere in there you will find the an app with the same name as the app you want to uninstall. I guess finding it is the hardest part.

![get-package](/images/posts/get-package.jpg)

To help locating an app in the huge list of installed apps you can filter said list using the command `Get-AppxPackage –Name *Some part of the name*`. This returns only apps matching your criteria. Powershell lists a lot of properties for each of the apps you have installed. The property you're after is `PackageFullName` which is the one that we will use to remove the package.

### Removing the app forever

Now that you've identified the app you want to remove it's time to say your goodbyes. Type `Remove-AppxPackage` with the full package name that you found in the previous step. As a sample I used `Remove-AppxPackage Microsoft.ZuneMusic_2.6.672.0_x64__8wekyb3d8bbwe –confirm`, because well... Who needs something Zune related?

[![zuneapp](/images/posts/zuneapp1.jpg)](/images/posts/zuneapp1.jpg)

Adding the confirm parameter means that you will be given a confirmation message to check if you're 100% sure you want to uninstall the app. Hitting the `Y` button will uninstall it and you can continue re-installing the newer version.
