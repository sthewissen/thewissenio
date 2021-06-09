---
layout: post
title: How to provide negative numeric input on Xamarin.Forms iOS
date: '2020-10-06 16:06:52 +0200'
image: '/images/headers/keyboard.jpeg'
categories: Code
tags: xamarin xamarin.forms ui
---
When creating a text input in Xamarin.Forms you might want to show a numeric keyboard. However, when setting it up and running your app on iOS you can't put in negative numbers. What's up with that?
### Looking at the problem...
As you probably know by now, Xamarin.Forms is an abstraction layer on top of various mobile platforms. However, each platform implements its own types of keyboards. This means that Xamarin.Forms needs to find some common ground between all of these. This results in the following types being available in Xamarin.Forms:
*   Chat
*   Default
*   Email
*   Numeric
*   Plain
*   Telephone
*   Text
*   Url
As you can tell from this list your best bet to provide adequate numeric input is probably the `Numeric` option. Let's take a look at how that looks across both iOS and Android:
![](/images/posts/keyboards.jpeg)
*Left: iOS keyboard, Right: Android keyboard.*
But what if we require the input of negative numbers? We might have a small issue here, as the iOS version does not provide that option by default. I've even noticed that the Android keyboard can differ per manufacturer. Eek!
![](https://media.giphy.com/media/Tk76voGUJyzh8Fg7zG/giphy.gif)
### Fixing the keyboard problem
This might be a tricky question to answer. To override behavior in Xamarin.Forms for specific platforms we typically go down [to the renderer level](https://docs.microsoft.com/en-us/xamarin/xamarin-forms/app-fundamentals/custom-renderer/). The best option is probably to override the `Numeric` type in a custom renderer to use a different native iOS keyboard.
![](images/posts/1_v3li23Q8UkrTFFsLXU62Wg.png)
*The different iOS keyboards, as outlined in [this blog post](https://medium.com/better-programming/12-shades-of-keyboard-types-in-ios-a413cf93bf4f)*
The graphic above shows all the types available to us. But wait, there are only a few numeric types and none of them contain the right symbols to put in a negative number. Our best bet seems to be the `NumbersAndPunctuation` version, that opens up a full keyboard with the numeric tab selected. It's not optimal, because it still allows for alphanumeric input, but it's the best we have available to us. Let's look at what the renderer looks like:
<script src="https://gist.github.com/sthewissen/6ff256c9e664ff47285f9a0728b63191.js"></script>
### Conclusion
We looked at how to easily influence the type of keyboard that Xamarin.Forms shows on a specific platform. Unfortunately, we are limited by the options that each platform offers us, so you might not find a keyboard suitable for your goals. There are different modifiers available that you can apply to [further customize](https://docs.microsoft.com/en-us/xamarin/xamarin-forms/user-interface/text/entry#customize-the-keyboard) your keyboard, but these don't fundamentally change the base version.
