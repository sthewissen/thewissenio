---
layout: post
title: 'A quick explainer: recent NuGet packages'
date: '2019-05-21 16:50:43 +0200'
categories:
- Code
tags:
- xamarin
- nuget
- ui
- plugins
---




Recently I've been pushing out a few NuGet packages with components that I use in my every day Xamarin work. This blog post is meant to give you a little overview of these packages and how they can help you in your daily mobile development flow.




 







### PancakeView




Modern design tends to work a lot with borders, rounded corners, gradients, and shadows. Within Xamarin.Forms there's not really a control available that supplies all of these things and lets you combine them to your heart's content. The `Frame` control comes close but wasn't quite cutting it for me. That's why I created the `PancakeView`!







![](https://github.com/sthewissen/Xamarin.Forms.PancakeView/raw/master/images/pancake.gif)
*The sample app for PancakeView.*



And why is it called a `PancakeView` you ask? Well, pancakes are also round, have shadows and have a glorious gradient color. What better fit can you think of?





The project can be [found on Github](https://github.com/sthewissen/Xamarin.Forms.PancakeView) and [NuGet](https://www.nuget.org/packages/Xamarin.Forms.PancakeView). After installing the NuGet you need to tell your XAML page where it can find the PancakeView, which is done by adding the following attribute to the ContentPage:

<script src="https://gist.github.com/sthewissen/ff002d64b25b6b8c40471cb913ad596b.js"></script>


Next up, just smack a PancakeView onto that page and you're all set, simple as baking real pancakes!

<script src="https://gist.github.com/sthewissen/ee46b8f234ee05f67938a9a356ae191d.js"></script>


### DebugRainbows




This package aims to solve a problem a lot of UI tinkerers like myself face; how is that element positioned? Currently, the easiest way to figure out how a UI element is positioned in Xamarin.Forms is by setting its background color. Luckily, DebugRainbows does exactly that by the flip of a switch! After flipping the switch, the package will assign a random background color to each UI element, allowing you to get a better idea of how the layout is composed.







![](https://raw.githubusercontent.com/sthewissen/Xamarin.Forms.DebugRainbows/master/images/sample.png)
*A sample app with DebugRainbows disabled and enabled.  
*



It's also [available on Github](https://github.com/sthewissen/Xamarin.Forms.DebugRainbows) and [NuGet](https://www.nuget.org/packages/Xamarin.Forms.DebugRainbows) and pretty easy to use. Install the package and add the following attached property and namespace declaration to your `ContentPage`:

<script src="https://gist.github.com/sthewissen/c822bc6e25a27b685feeb347286754da.js"></script>


### EasyLoading




At some point in your app's lifetime, you will need to load data from an external source. This is usually accompanied by implementing some sort of visual loading mechanism to inform the user of the fact that he/she needs to wait. In Xamarin.Forms there's an `ActivityIndicator` but these days new loading paradigms are the new norm. By adding things like a skeleton loader or a full-screen loading overlay with animations we can make our app a less static/boring experience.







![](https://raw.githubusercontent.com/sthewissen/Xamarin.Forms.EasyLoading/master/images/sample.gif)




This package introduces a LoadingLayout bindable property where we can define a loading template for every layout on a page. By binding to a boolean indicating if we're loading we can create a completely custom loading experience. All of the relevant code is contained within the elements it logically applies to.





This package is [on Github](https://github.com/sthewissen/Xamarin.Forms.EasyLoading) and [NuGet](https://www.nuget.org/packages/Xamarin.Forms.EasyLoading). After installing it you can add a loading template to any layout element.

<script src="https://gist.github.com/sthewissen/1bda7b9f97c30752a369acdf43ab82dd.js"></script>


If you want to create a loader for a list of items you can use the `RepeatCount` bindable property to repeat the template multiple times. This allows you to create e.g. a skeleton loader with multiple skeleton items being repeated vertically.




### Pull requests welcome!




If any of these packages has sparked your interest or if you have ideas of your own I welcome PRs! I'm sure they can be extended with additional awesome features I haven't thought of yet. Go ahead, check out their Githubs and raise an issue or PR!


