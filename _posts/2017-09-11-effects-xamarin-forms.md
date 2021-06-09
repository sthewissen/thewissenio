---
layout: post
title: Using Effects in Xamarin Forms
date: '2017-09-11 11:47:07 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
- ui
---



Developers can use Effects in Xamarin Forms to customize native controls and add some styling of their own. But why not simply use a custom renderer to achieve the same thing? While that is certainly possible there are some benefits to Effects.



### Why would you use Effects?




Contrary to a custom renderer that always targets controls of a specific type an effect can be re-used throughout your app. Another advantage is that you can parameterize your effects with additional data. Most people use effects to simply change properties of a native control that aren't yet made available through the existing Xamarin Forms controls. Effects work by attaching/detaching them to/from a Xamarin Forms control.



To get a quick idea of how that looks in XAML:



<script src="https://gist.github.com/sthewissen/fa8c0c2dbe460509188bd1ac3b0a1f62.js"></script>



You can add multiple effects to a control. As you might have noticed this gives you a lot of freedom because unlike a custom renderer you specifically decide which control gets the effect without any need to subclass it. When creating an effect it is not mandatory to implement it in each platform. You can create an effect and choose to only implement it in iOS. It's completely optional.



### Creating our first Effect




We're going to create an effect which puts an awesome cat as the background image of an `Entry`. To get started we create a class in our PCL that inherits from `RoutingEffect` which has no code but we're going to use it to make sure we can consume our effect in our XAML code:



<script src="https://gist.github.com/sthewissen/9a5c5325dccb8c62d0e3168911bec98e.js"></script>



This class calls the `RoutingEffect` base class constructor and passes in a string parameter. Take note of this parameter as you will be seeing it later on in this sample. It is used to initialize an instance of this effect at runtime and is a concatenation of 2 variables we'll be seeing in the platform-specific implementations of our effect.



### Creating the platform-specific code




To actually create the custom Effect you need to subclass the `PlatformEffect` class in your platform-specific projects and each platform-specific `PlatformEffect` class subsequently exposes the following properties for you to use:



*   `Container` – the platform-specific control being used to implement the layout.

*   `Control` – the platform-specific control.

*   `Element` – the Xamarin.Forms control that's being rendered.



When inheriting from `PlatformEffect` you also gain access to two methods for you to override: `OnAttached` and `OnDetached`. You can use `OnAttached` to apply your effect and `OnDetached` to clean up your effect. Now let's create our effect shall we?



On iOS we implement it as follows: <script src="https://gist.github.com/sthewissen/d3c66d134c58f1d2fbd7593f1fb78e80.js"></script>



On Android our effect code looks like this: <script src="https://gist.github.com/sthewissen/ffbae3716f7222201dd2057b8a629579.js"></script>



As you can see there are 2 `assembly` attributes decorating our effect.



<script src="https://gist.github.com/sthewissen/b94ac3687910166fc567519e53a7da45.js"></script>



You might remember I talked about passing a string value into the constructor of your `RoutingEffect` class in your PCL a bit higher up in this post. These two values uniquely identify this specific effect and are the linking pin between your PCL code and your platform-specific code. These two values need to match the string in your PCL code (concatenated with a period character in between). It's what makes the whole thing come together!



[![The result of our Effects](/images/posts/effect.jpg)](/images/posts/effect.jpg)



Obviously this leaves a lot to be desired and it serves solely as a sample of how effects work and I can't call this one production-worthy :) There are however ways you can implement your effects that can be a lot more useful. Some samples include:



*   Creating drop shadows on visual elements

*   Setting keyboard types on an entry

*   Setting auto-correct settings on an entry

*   Etc.



 



### Sharing is caring




Why did I create such a useless effect to show off how effects work instead of creating one from the list above? Because the ones I mentioned have already been created by other people! The beauty of Effects is that you can easily share them which is exactly what some people have done. The [FormsCommunityToolkit](https://github.com/FormsCommunityToolkit/FormsCommunityToolkit) is a project that tries to aggregate Effects (among other things) and you can contribute to it if you've created one. Since it already contains some nice ones you don't have to recreate them yourself.



### A word of warning...




You can attach effects to any type of view however you need to take care of the fact that someone might attach your effect to a `Button` even though it was meant to work with an `Entry` control. Xamarin Forms does nothing to stop this behaviour. You will need to take care of graceful exception handling yourself just in case this type of thing occurs either by also implementing it for `Button` or by silently (yet gracefully) failing.

