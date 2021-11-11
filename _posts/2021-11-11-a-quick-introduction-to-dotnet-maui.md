---
layout: post
title: A quick introduction to .NET MAUI
date: '2021-11-11 15:38:00 +0000'
image: '/images/headers/maui.jpg'
categories: Code
tags: xamarin xamarin.forms maui
---
Have you ever done any mobile development in the Microsoft ecosystem? Then you might’ve heard about Xamarin. The technique, at this point synonymous with the company that originally built it, goes back all the way to 2011. It has been Microsoft’s main mobile development offering since 2016, when they acquired the company. 

Xamarin allows developers to use C# code to develop applications for iOS, Android and UWP primarily, using Visual Studio. It does all of this from a shared codebase meaning that unless you want to do something that is platform-specific you can achieve most of what you want from a single shared library. 

The advent of Xamarin.Forms provided an additional abstraction layer on top of that shared codebase with which you can define your user interface in a shared fashion through XAML. To improve the development experience, Microsoft created a lot of additional tooling over the years, making Xamarin a complete offering for mobile developers. The natural next step of that effort was introduced at Build 2020 in the form of the .NET Multi-platform App UI (.NET MAUI). In this article we’ll dive deeper into what it is, and what the biggest changes compared to Xamarin.Forms are.

## What is .NET MAUI?

.NET MAUI is the evolution of what is currently Xamarin.Forms. There is now a single .NET 6 Base Class Library (BCL) where the different types of workloads such as iOS and Android are now all part of .NET. It effectively abstracts the details of the underlying platform away from your code. If you’re running your app on iOS, macOS or Android you can now rely on that common BCL to deliver a consistent API and behavior. On Windows, CoreCLR is the .NET runtime that takes care of this.

Even though this BCL allows you to run the same shared code on different platforms, it does not allow you to share your user interface definitions. The need for an additional layer of UI abstraction is the problem .NET MAUI will solve, while simultaneously branching out towards various additional desktop scenarios.

Looking at it from an architectural perspective, most of the code you write will interact with the upper two layers of the diagram shown in Figure 1 below. The .NET MAUI layer handles communication with the layers below it. However, it will not prevent you from calling into these layers if you need access to a platform-specific feature.

![The architecture behind .NET MAUI](/images/posts/maui-architecture.jpg)
*The architecture behind .NET MAUI*

Making the move to .NET MAUI is also an opportunity for the Xamarin.Forms team to rebuild the 8 year old toolkit from the ground up and tackle some of the issues that have been lingering at a lower level. Redesigning for performance and extensibility is an integral part of this effort. Companies all over the world use Xamarin extensively, so making these changes in the current toolkit quickly becomes near impossible. If you've previously used Xamarin.Forms to build cross-platform user interfaces, you'll notice many similarities when starting to look into .NET MAUI. There are a few differences worth exploring though, which we'll look into in a follow-up post.

_This post was originally part of an article written for CODE Magazine's [Focus issue on .NET 6.0](https://www.codemag.com/Magazine/Issue/dotnet6)._