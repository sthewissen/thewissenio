---
layout: post
title: Exploring grid overlays in DebugRainbows
date: '2020-02-18 20:28:00 +0100'
categories: Code Short
tags: xamarin xamarin.forms plugins
image: '/images/headers/rainbows.jpg'
---
I recently released a new version of my DebugRainbows plugin, which adds grid overlays to the set of debugging tools it offers. Let's take a closer look at what they are and how to use them!

### How did we get here?

The same way we always get here, Pinky. Designers. As a developer you may not be blessed with pixel-perfect vision, but there are people out there who are. While you're happily coding away at your app they are checking it for all sorts of things, one of which is the alignment of your UI elements. And if they don't align you're in for a scare!

![](/images/posts/brains.gif)

So how can we improve this situation? You might know DebugRainbows ? from its colourful element highlighting, which enables you to easily see the amount of space an element takes up. However, this doesn't necessarily make it easier to spot whether or not your elements align correctly. The new debugging grid feature does though!

### Exploring how it works

They say a picture says more than a thousand words, and the same can be said for this plugin. In the picture below you can see the two different flavours it has to offer in action. The mode on the right is heavily inspired by [Jeff Wilcox's MetroGridHelper](https://www.jeff.wilcox.name/2011/10/metrogridhelper/) which you might know of if you're an old-school Windows Phone kind of guy.

![DebugRainbows in action](/images/posts/image-37.png)
*DebugRainbows in Line and Block mode.*

What this new feature essentially offers you is a set of vertical and horizontal guides that help you make sure that your design is implemented pixel perfectly. Just like your designers want you to. Usually professional designs tend to adhere to a grid scheme where they're always using a multiple of a certain number for each element's size, padding and margins. An overlay like this really helps you stick to that principle. It also helps keep your design consistent across different screen sizes offering your users a better user experience.

The grid you see above is completely customisable, from the size of the items up to the amount of major gridlines to show. The amount of customisation available should enable you to make it suit your needs perfectly. A full API reference can be found on [the GitHub page](https://github.com/sthewissen/Xamarin.Forms.DebugRainbows#api-reference) for the project. The new features are now available in v1.1.4, which you can find [on NuGet](https://www.nuget.org/packages/Xamarin.Forms.DebugRainbows).