---
layout: post
title: Breaking the Pancake mould
date: '2019-08-25 19:40:25 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
- nuget
- plugins
---

You may have used `PancakeView` in your Xamarin.Forms adventures in the past. Ever dreamed of breaking out of that rectangular/circular mould? Well, now you can with the latest `PancakeView` update!

 

### Introducing 1.1.8

A while ago, a gentleman by the name of Shanmukha Ranganath [submitted a PR](https://github.com/sthewissen/Xamarin.Forms.PancakeView/pull/32) to `PancakeView` aiming to support other shapes as well. By introducing a `Sides` property it has now become possible to create pretty much any polygonal shape as long as it's symmetrical. Because of the vast amount of options that it already supported it was quite a chore to get it all to work together correctly. An effort that we both poured quite a few hours into, but the end result was well worth it.

![](https://github.com/sthewissen/Xamarin.Forms.PancakeView/raw/master/images/pancake.gif)

We also greatly improved all of the rendering bits on both iOS and Android to reduce the number of strange rendering bugs you might come across. I feel this addition really makes it an even more versatile control to use when creating a fancy looking layout. And it's all rendered natively on the platform!

### A new way of debugging your PancakeView

Part of this update is the new debugging experience in the sample project that is offered on GitHub. It is accessed by double-tapping the `PancakeView` logo when running the sample app, which brings you to a screen where you can tweak all of its options. To make this work, we had to rewrite some of our code to better handle all the redrawing when properties changed. This was a pain point to begin with, so finally sitting down and fixing it was well overdue.


> Just messing about with a new Debug Mode and new features ? [#XamarinForms](https://twitter.com/hashtag/XamarinForms?src=hash&ref_src=twsrc%5Etfw) [#FrameOnSteroids](https://twitter.com/hashtag/FrameOnSteroids?src=hash&ref_src=twsrc%5Etfw) [pic.twitter.com/qZIVTb8j32](https://t.co/qZIVTb8j32)
> 
> 
> 
> &mdash; Steven Thewissen (@devnl) [August 10, 2019](https://twitter.com/devnl/status/1160255591278895104?ref_src=twsrc%5Etfw)
> 

 <script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

### Get it now and put it to work!

The update is [out on NuGet](https://www.nuget.org/packages/Xamarin.Forms.PancakeView) so update those projects and check it out for yourself. If you find anything that isn't working as it should don't hesitate to open an issue on GitHub. Got any additional features that could add even more value to it? Open up a PR and let's see if we can add it in!

