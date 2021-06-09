---
layout: post
title: 'Quick tip: Enabling DebugRainbows for an entire app'
date: '2019-07-28 09:17:52 +0200'
categories:
- Short
tags:
- nuget
- plugins
image: '/images/headers/candy.jpg'
---

If you're like me and mess around with UI in Xamarin.Forms a lot you might've come across the problem of a control or view not displaying as you'd expect it to. This little package may help you in finding out why.

### ❤️ Hot Reload

Let me start off by saying that over the course of the last few weeks I've been able to try out Xamarin.Forms Hot Reload. Besides the fact that it works great, it also teams up very nicely with DebugRainbows. You pretty much instantly get a feeling for where all the elements in your app are and the space they take up. Check out this sample below from my [#XamarinUIJuly](https://www.thewissen.io/create-a-kickass-banking-app-using-a-basepage-in-xamarin/) entry:

![](/images/posts/rainbow.png?style=halfsize)

### Enabling for an entire app at once

Adding DebugRainbows to your app is as simple as installing the [NuGet package](https://www.nuget.org/packages/Xamarin.Forms.DebugRainbows) and adding the `IsDebug="true"` attached property. However, if your app has a lot of pages, you might not want to go through the effort of adding the attached property to every single page. Luckily we can use a `Style` to get around this! Simply add the following style to the `ResourceDictionary` in your `App.xaml`. It will apply to every `ContentPage` in your app, effectively coloring the entire thing.

<script src="https://gist.github.com/sthewissen/c8d20144c10539f0f703f0105c157835.js"></script>