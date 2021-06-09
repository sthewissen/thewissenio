---
layout: post
title: Using compiled bindings in Xamarin.Forms
date: '2019-12-26 14:36:00 +0100'
categories:
- Code
tags:
- xamarin
- xamarin.forms
image: '/images/headers/crayons-1.jpg'
---
As a Xamarin developer, you have surely come across a scenario where you've mistyped a binding and didn't figure it out until hours later. Let's see if we can improve that with XAML compilation and compiled bindings!

### XAML Compilation
One part of improving this scenario is to enable [XAML compilation](https://docs.microsoft.com/en-us/xamarin/xamarin-forms/xaml/xamlc). It is off by default, meaning that creating a new project doesn't enable it for you yet. This is due to Xamarin wanting to ensure backwards compatibility. Adding support for XAML compilation is as simple as adding one line enabling it somewhere in your app. Most people decorate their `App.xaml.cs` with it.

<script src="https://gist.github.com/sthewissen/e7dccb89546099662ca33d8b8a598590.js"></script>

But what does it do? The most important part is that it checks your XAML files for errors during compile time immediately notifying you of any errors you made. Did you accidentally type `SnackLayout` instead of `StackLayout`? Without XAML compilation enabled you would still be able to run your app and it would either crash or simply not render your UI as it should. 

With XAML compilation enabled, you will see errors in your XAML files pop up in the Errors pane after your build has completed. This allows for quick and easy spotting of errors in your XAML. Additionally XAML compilation also reduces assembly file size and instantiation time for your XAML files.

![XAML compilation catches your errors at compile time](/images/posts/image-19.png)
*Adding XAML compilation catches al your spelling errors at compile time.*

### Getting started with compiled bindings

We've added XAML compilation to help us spot errors in our XAML files, but unfortunately, this does not extend into bindings. We can still mess them up and wouldn't be aware of it until we see potential errors appear at runtime. This is where compiled bindings will help us.

Regular bindings use reflection to be resolved at runtime, which makes it impossible to do compile-time validation. This process of reflection is also not a very cost-effective process and could add unnecessary overhead depending on the platform. Since compiled bindings resolve at compile-time a developer can quickly spot incorrect binding expressions. Enabling compiled bindings is simple:

1.  Enable XAML compilation as shown in the previous section.
2.  Use the `x:DataType` attribute to provide the data type of the binding context of a `VisualElement`.

The `x:DataType` attribute takes a type name as a string or you can use the `x:Type` extension to provide a type. The binding context of the element to which you apply `x:DataType` will be assumed to be the type you provide here. Looking at the sample code below we set the `BindingContext` of the page to an instance of `MainViewModel`. By also setting the `x:DataType` we automatically get compile-time binding validation on every element below this root element. If the `KidsName` property does not exist on the `MainViewModel` or we mistype its name we will see an error in our error pane.

<script src="https://gist.github.com/sthewissen/2dbbef80ba04d0003a5d54891f7675f7.js"></script>

### Compiled bindings and DataTemplate

As a mobile developer, you have very likely used a templated control at some point. Be it to show items in a list or a fancy carousel. As you may know, these types of controls that take a collection as input use their own data context where each item is bound to an item in the collection. Using `x:DataType` on a higher level in the view hierarchy would not work in this situation.

Luckily, to fix this, we can apply `x:DataType` on the `DataTemplate` element. Since it can be applied and redefined anywhere in the view hierarchy this will work exactly the same as shown before. Here's a small code sample using `CollectionView`:

<script src="https://gist.github.com/sthewissen/ba8c1c5e7599e28bcbca53e4511374e3.js"></script>

If a property named `Description` does not exist in the `ItemViewModel` class the compiler will now throw an error. As you can see, adding `x:DataType` where applicable can really make your life a lot easier when it comes to setting up bindings.

### Why not just use these everywhere?

There are some scenarios where compiled bindings won't work. One example is when using the `Source` attribute on a binding. This attribute cannot be resolved at compile-time, so bindings with the `Source` attribute are excluded as compiled bindings by design. Nevertheless, it's good practice to set the `x:DataType` attribute at the same level in the view hierarchy as the [`BindingContext`](https://docs.microsoft.com/en-us/dotnet/api/xamarin.forms.bindableobject.bindingcontext#Xamarin_Forms_BindableObject_BindingContext) is set. Your developer experience will definitely benefit from it.