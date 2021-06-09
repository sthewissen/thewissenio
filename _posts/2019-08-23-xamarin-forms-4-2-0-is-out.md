---
layout: post
title: Xamarin.Forms 4.2.0 is out!
date: '2019-08-23 14:49:03 +0200'
categories:
- Short
tags:
- xamarin
- xamarin.forms
image: '/images/headers/mountains.jpg'
---

A new version of Xamarin.Forms has hit NuGet feeds around the globe. Let's take a quick peek at what has changed under the hood!

### Improvements to Shell

Shell has taken the Xamarin.Forms world by storm it seems. I personally **STILL** haven't really used it that much, but that's mainly due to me just being too lazy to start. Also, the apps I'm working on already have a lot of the stuff it offers in place and replacing is an effort I'm not quite ready for yet.

Xamarin.Forms 4.2.0 gives you a few new events that help you on your Shell journey. By hooking up to `OnAppearing` and `OnDisappearing` you will have a bit more control over the lifecycle of your pages.

A few other bugs have been fixed as well, one of which was [submitted by yours truly](https://github.com/xamarin/Xamarin.Forms/issues/6060) ? I ran into this bug while building part of Xappy on a live stream with David Ortinau. Using Shell and a PanGestureRecognizer would not work fluently on Android due to touch events being intercepted improperly.

![A simple example of using Xamarin.Forms Shell](http://devblogs.microsoft.com/xamarin/wp-content/uploads/sites/44/2019/05/Scenarios-for-Shell.png)
*A simple Xamarin.Forms Shell app*

### Moarrr CollectionView!

Xamarin is promoting `CollectionView` as the best thing since `ListView` and rightfully so. However, at the moment it still is lacking some functionality such as headers/footers to make it a drop-in replacement. No more! Headers and footer templates are in and some other cool bits like pull-to-refresh are actively in development. It will only increase to grow in functionality, which is awesome. However, due to this still being very much in development it is staying behind the experimental feature flag for now. So if you've already been using it, nothing really changes ?

###  Community contributions

As you probably know, Xamarin.Forms is an abstraction layer on top of the native platforms. Even though a lot of the native APIs have been mapped already there are still some things left to be done. This release adds a few of those, such as setting the `ThumbColor` on a `Switch` which up until this point would have to be written into your own custom renderer.

![New ThumbColor property](http://devblogs.microsoft.com/xamarin/wp-content/uploads/sites/44/2019/08/Thumb.png)
*Thumb color can now be set :)*

For a full list of all the changes, check out [the release notes](https://docs.microsoft.com/nl-nl/xamarin/xamarin-forms/release-notes/4.2/4.2.0).