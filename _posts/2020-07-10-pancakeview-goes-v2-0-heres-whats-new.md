---
layout: post
title: PancakeView goes v2.0! Here's what's new.
date: '2020-07-10 16:00:00 +0200'
categories: Code
tags: xamarin xamarin.forms nuget plugins
image: 'images/headers/pancakes_smile.jpeg'
---
It's been in the making for quite a while and the road to getting to the end result has been quite a struggle. However, it's finally time to release version 2.0 of PancakeView!
### What's new?
So what does this new version have to offer? Let's quickly go through the most important features it packs. If any of these are particularly to your liking, don't hesitate to [let me know on Twitter](https://twitter.com/devnl)!
#### Gradients improved
Gradient support is something that is coming to Xamarin.Forms, so improving the gradients on PancakeView is a task that needed to be done. I added a few things to support this:
*   Made all the properties on `GradientStop` bindable
*   Introduced `GradientStartPoint` and `GradientEndPoint` instead of `GradientAngle`
Making the properties on `GradientStop` bindable allows you to create complex coloring animations like hue shifting gradients, which are awesome! The old `GradientAngle` property only allowed for 360 gradient rotation around a central point. By adding both a start and endpoint you can pretty much create any orientation for your gradient.
![Gradients in the PancakeView sample app.](images/posts/image-59.png)
#### Border & shadow API changes
The old API surface for PancakeView when it comes to borders and shadows felt a bit messy. All of the related properties used to be properties on the PancakeView itself, prefixed by the word "Border" or "Shadow". Adding features would only increase the amount of overhead, so I've decided to abstract these properties away into their own objects.  
<script src="https://gist.github.com/sthewissen/34e826f90958d154b90c2da12a328e67.js"></script>
Adding these to your XAML has become easier on the eyes as well. You can either set these properties directly on a `Border` object:  
<script src="https://gist.github.com/sthewissen/a9269d5ab6af83dc4105ea12d1f26320.js"></script>
Or use the markup extension that was also added:  
<script src="https://gist.github.com/sthewissen/6f024fe8c6993a66c41661039e81970b.js"></script>
#### macOS support
Building macOS apps with Xamarin.Forms is not the biggest thing since sliced bread. Supporting macOS is a fairly simple conversion process when you already have the iOS version lined up though. So why not add it?
![PancakeView for macOS!](images/posts/pancake_macos-1.gif)
#### SourceLink support
Even though [enabling SourceLink](https://docs.microsoft.com/en-us/xamarin/xamarin-forms/internals/sourcelink?pivots=macos) is not a big task the benefits it adds are quite significant. When SourceLink is enabled for your NuGet package Visual Studio will download source code files during debugging and allow developers to step through code, enabling debugging of packages without building from source.
### A little note about UWP / WPF
While PancakeView has support for UWP to a certain extent and a rudimentary implementation for WPF is available. However, from this version onwards, support for these platforms will not be done by me. Any support on these will need to come from the community from now on, as they are not platforms I want to focus on. I'll gladly accept any pull requests introducing both existing and new features of PancakeView on these platforms.
#### Update (Tuesday, 15 July 2020)
I see that making the UWP version of PancakeView community-support instead of first-party support from v2.0 onwards has gotten people talking. Let me explain what that means in a bit more detail just in case things are being misinterpreted...
Let's hit on a few points right off the bat: (1) The original implementation was already a community contribution for the most part (2) The current UWP version is approx. 70% feature complete. It's been that way ever since it was introduced, so nothing has really changed there. What is changing is that I won't be investing the time in bridging that last 30% gap to make it feature complete. I personally don't have enough interest in the platform and I can only spend my time once. I’ve chosen to spend it on things that pique my interest more.
The other main reason for me to not provide first-party support for it is not even having an adequate Windows dev environment. I work pretty much exclusively on Mac. It makes it very hard to get any work on it done from my end. So yes, this essentially boils down to the investment of both time and money. A developer's most precious resources I suppose. In the two years that it's been out hardly anyone has ever asked me anything about the UWP version or bridging that feature gap.
Does that mean no one uses it? Unfortunately, I don't have statistics on its usage but to me, that does suggest it to be minimal. I might be horribly mistaking here though. Either way, hopefully, this clarifies the reasoning behind it. Don't hesitate to ask if you have questions.
### What's next for PancakeView?
That truly is the million-dollar question. Truth is I'm not sure. I have a list of features that make for good additions, but other packages such as good friend Jean-Marie Alfonsi's [Sharpnado](http://www.sharpnado.com) suite already provide these capabilities. Things like more granular control over shadows or an acrylic type look & feel are already available in that.
Besides that, my own interests are also shifting. PancakeView does what I want it to do as is. It suits my needs. I'll probably leave it to rest for a while after this release and pick it up again in the future. So, with that being said, I do want to thank everyone who's supported the package over the last few years. The fact that so many people are actually using it amazes me to this day, as that was definitely not what I expected when I set out making it ❤️