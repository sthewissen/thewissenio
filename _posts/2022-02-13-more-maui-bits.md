---
layout: post
title: More MAUI bits!
date: '2022-02-13 18:45:00 +0000'
image: '/images/headers/maui4.jpg'
categories: Code
tags: xamarin xamarin.forms maui
---

This post covers a few different topics, namely single project, the Xamarin Community Toolkit and migrating from Xamarin.Forms to MAUI.

## Moving resources to a single project

One of the common pet peeves with Xamarin.Forms is the need to copy a lot of similar resources across multiple projects. If, for example, you have a specific image you want to use in your app, you must include it in all the separate platform projects, and preferably provide it in all the different device resolutions you’d like your app to support. Other types of resources, such as fonts and app icons suffer from a similar issue.

The new single project feature in .NET MAUI unifies all these resources into a shared head project that can target every supported platform. The .NET MAUI build tasks will then make sure that these resources end up in the right location when compiling down to the platform-specific artifacts. The single project approach will also improve experiences such as editing the app manifest and managing NuGet packages. The image below shows a mockup of what the single project experience could look like in Visual Studio. The same project that also contains your other shared logic will also contain the shared resources.

![The new Single Project experience in Visual Studio.](/images/posts/singleproject.jpg)
*The new Single Project experience in Visual Studio.*

## What will happen to other popular libraries?

A lot of publicly maintained libraries will need to be ported over to .NET MAUI by their creators. .NET Standard libraries without any Xamarin.Forms types will likely work without any updates. Other libraries will need to adopt the new interfaces and types, and recompile as .NET 6 compatible NuGets. Some of these have already started this process by releasing early alpha/beta versions of their libraries. If you’ve ever developed a Xamarin application in the past, you’ve most likely also used Xamarin.Essentials and/or the Xamarin Community Toolkit. 

Essentials now ships as part of .NET MAUI and resides in the Microsoft.Maui.Essentials namespace. 

Just like Xamarin.Forms is evolving into .NET MAUI, the Xamarin Community Toolkit is evolving as well and will be known as the .NET MAUI Community Toolkit moving forward. It will still be the fully open-source, community supported library that it is today, but it is merging with the Windows Community Toolkit which allows for more efficient code sharing and combining engineering efforts across both toolkits. The Xamarin Community Toolkit will also receive service updates on the same public schedule as Xamarin.Forms.

Check out the .NET MAUI Community Toolkit at: https://github.com/CommunityToolkit/Maui

## Transitioning your existing app to .NET MAUI

While Microsoft does not recommend porting your existing production apps to .NET MAUI right now, providing an upgrade path once .NET MAUI releases has always been a priority. Due to the existing similarities between Xamarin.Forms and .NET MAUI the migration process can be straightforward. The .NET Upgrade Assistant is a tool that currently exists to help you upgrade from .NET Framework to .NET 5. With the help of an extension on top of the .NET Upgrade Assistant, you are able to automate migrating your Xamarin.Forms projects to a .NET MAUI SDK style project while also performing some well-known namespace changes in your code. It does so by comparing your project files to what they need to be to be compatible with .NET MAUI. The .NET Upgrade Assistant then suggests the steps to take to automatically upgrade and convert your projects. It will also map specific project properties and attributes to their new versions, while stripping out obsoleted ones. By using extensive logging as shown below you will be able to know all the steps the tool has taken to upgrade your project. This will also help you debug potential issues during your migration.

![Informational output from the .NET Upgrade Assistant for .NET MAUI.](/images/posts/upgradeassistant.jpg)
*Informational output from the .NET Upgrade Assistant for .NET MAUI.*

During the early days of .NET MAUI, there might not be adequate support for some of your NuGet packages yet. The .NET Upgrade Assistant works with analyzers to go through and validate whether these packages can be safely removed or upgraded to a different version.

While it is not 100% able to upgrade your project, it does take away a lot of the tedious renaming and repeating steps. As a developer you will have to upgrade all your dependencies accordingly and manually register any of your compatibility services and renderers. However, Microsoft has stated that they will try to minimize the effort this takes as much as possible. Additional documentation on the exact process will be made available closer to release.

Check out the .NET Upgrade Assistant at: https://dotnet.microsoft.com/platform/upgrade-assistant

## Conclusion

Developers who have worked with Xamarin.Forms in the past will find a lot of things in .NET MAUI to be familiar. The underlying changes to infrastructure, broader platform scope and overall unification into .NET 6 also make it appealing to people new to the platform. Centralizing a lot more resources and code into the shared library using single project greatly simplifies solution management. Additional performance improvements through using handlers gives the seasoned Xamarin developer something to explore. 

While the version of .NET MAUI in .NET 6 is highly anticipated, it is also only the first version of the platform. I personally expect a lot of additional features coming soon, and best of all; the entire platform is open source. That means you and everyone else in the .NET ecosystem can contribute to improve and enhance the platform. I’m certainly curious to see what the future holds!

If you want to try out .NET MAUI for yourself, you can check out the GitHub repository and the Microsoft Docs, which are already providing content on getting started.

_This post was originally part of an article written for CODE Magazine's [Focus issue on .NET 6.0](https://www.codemag.com/Magazine/Issue/dotnet6). This article was written based on the available Preview builds at the time. Current previews might have changed things compared to the article._