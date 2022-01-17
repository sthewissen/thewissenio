---
layout: post
title: Adopting the .NET Generic Host
date: '2022-01-30 17:24:00 +0000'
image: '/images/headers/maui3.jpg'
categories: Code
tags: xamarin xamarin.forms maui
---

Coming from the ASP.NET Core space, you may already be aware of the .NET Generic Host model. It provides a clean way to configure and start up your apps. It does so by standardizing things like configuration, dependency injection, logging and more. We commonly refer to the object encapsulating all of this as the host, and it’s typically configured through the `Main` method in a `Program` class. Alternatively, a `Startup` class can also provide an entry point to configuring the host. This is what the out-of-the-box generic host in ASP.NET Core looks like:

<script src="https://gist.github.com/sthewissen/109473a44ad1451a8ef0eb5ae86eff2d.js"></script>

Because .NET MAUI will also use the .NET Generic Host model, we will be able to initialize our apps from a single location moving forward. It also provides us with the ability to configure fonts, services, and third-party libraries from a centralized location. We do this by creating a `MauiProgram` class with a `CreateMauiApp` method. Every platform invokes this method automatically when your app initializes. 

<script src="https://gist.github.com/sthewissen/417fa7b0aff397b8bb99d2e3bd0f423a.js"></script>

The bare minimum this `MauiProgram` class needs to do is to build and return a `MauiApp`. The `Application` class, referenced as `App` in the `UseMauiApp` method, is the root object of your application. This defines the window in which it runs when startup has completed. The `App` is also where you define the starting page of your app.

<script src="https://gist.github.com/sthewissen/584bbcdbd5ce96e42cea81cd005676de.js"></script>

We’ve covered the new concept of handlers earlier in this article. If you’re looking to hook into this new handler architecture, the `MauiProgram` class is where you register them. You do this by calling the `ConfigureMauiHandlers` method and calling the `AddHandler` method on the current collection of handlers.

<script src="https://gist.github.com/sthewissen/bc3b0457be34c4a7aafa9d09e900e076.js"></script>

In this sample, we are applying the `MyEntryHandler` to all instances of `MyEntry`. The code in this handler will therefore run against any object of type `MyEntry` in your mobile app. This is the preferred solution for when you want to target a completely new control with your handler. If all you want to do is change a property on an out-of-the-box control you can do this straight from the `MauiProgram` class as well, or really anywhere you know your code will run prior to the control being used.

<script src="https://gist.github.com/sthewissen/f79b58fc8815a8988da9d6fe3ead27a5.js"></script>

This sample uses compiler directives to indicate that the handler code should only run on the Android platform because it uses APIs that are unavailable on other platforms. If you’re doing a lot of platform-specific code, you might want to consider using other multi-targeting conventions instead of littering your code with compiler directives. This essentially means separating your platform-specific code into platform-specific files suffixed with the platform name. By using conditional statements in your project file, you can then ensure that only the platform-specific files are included when compiling for those specific platforms.

## Using existing Xamarin.Forms custom renderers

If you’re looking to migrate an existing Xamarin.Forms app to .NET MAUI you might already have written custom renderers to handle some of the functionality of your app. These are usable in .NET MAUI without too much adjustment, however, it is advised to port them over to the handler infrastructure. To use a Xamarin.Forms custom renderer register it in the `MauiProgram` class.

<script src="https://gist.github.com/sthewissen/ea0759f7708f92e8f04821b5be733d3e.js"></script>

Using the `AddCompatibilityRenderer` method, we can hook up a custom renderer to a .NET MAUI control. You need to do this on a per-platform basis, so if you have multiple platforms you will need to add the renderer for each platform individually.

_This post was originally part of an article written for CODE Magazine's [Focus issue on .NET 6.0](https://www.codemag.com/Magazine/Issue/dotnet6). This article was written based on the available Preview builds at the time. Current previews might have changed things compared to the article._