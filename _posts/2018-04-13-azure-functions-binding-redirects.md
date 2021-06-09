---
layout: post
title: Performing a binding redirect in Azure Functions
date: '2018-04-13 12:03:44 +0200'
categories:
- Code
tags:
- azure
- azure functions
---

I've blogged about Azure Functions before and have speaken highly of it as well. While diving deeper into them there are definitely some drawbacks to be found though. How about doing a binding redirect?

### The binding redirect debacle

The biggest problem I've come across in recent history is the lack of support for binding redirects. But what exactly is a binding redirect? Well, let's say you need a common NuGet package like **Newtonsoft.Json** and want the greatest new and fancy features. You take v11.0.2 (as of this writing) from the NuGet package manager and get busy. Internally, the [Azure Functions SDK NuGet](https://www.nuget.org/packages/Microsoft.NET.Sdk.Functions/) package also has a dependency on Newtonsoft.Json but it uses v9.0.1. Since you cannot reference multiple different versions of the same assembly a binding redirect tells the system that you want to redirect all references of the older version to the newer one. No such thing exists in Azure Functions.

So let's talk a bit about the solutions you have here. The easiest solution is to use the lower version package and hope that it suits your needs. It doesn't feel good, but it's the easiest way to solve the problem. However, what happens when two NuGet packages you're using depend on a specific  Newtonsoft.Json version that is <span style="text-decoration: underline;">**NOT**</span> the version Azure Functions needs? Perhaps the two even rely on different versions. You might be able to fork the code of those packages and downgrade the version of the Newtonsoft.Json package but you're going down a really deep rabbit hole once you start with that. It's not a viable solution.

![](/images/posts/alice.jpg)

### So what can you do?

> **Disclaimer:** The solution below applies to the full .NET framework version of Azure Functions (v1). There is a Azure Functions v2 available that is .NET Standard compliant but there is **no solution** for this problem for the v2 version of Azure Functions. The handler mentioned in the manual binding redirect solution below is never called and discussions about this topic have gone on for quite some time on the [Azure Functions Github](https://github.com/Azure/Azure-Functions). A tentative solution date is given as [May 2018](https://github.com/Azure/azure-functions-host/wiki/Assembly-Resolution-in-Azure-Functions#what-the-challenges-when-running-on-azure-functions) but I wouldn't hold my breath for that.
> 

This solution was initially created by [Codopia](https://codopia.wordpress.com/2017/07/21/how-to-fix-the-assembly-binding-redirect-problem-in-azure-functions/) which has helped me to eventually get this thing running. I'm sharing it here because there is not enough documentation on the issue provided by the Azure Functions team and this solution needs to be known more.

Start off by creating a few helper classes that we will need to get this to work. The first class is called *AssemblyBindingRedirectHelper* which is where all the magic happens. This class adds a custom handler to the assembly resolving event that gets triggered from our appdomain. This enables us to load the assembly with the version of our choosing. As soon as a piece of code in that assembly is called this event is triggered. We will define an app setting that contains which binding redirects we want to perform later.

<script src="https://gist.github.com/sthewissen/fc000387f26f4475e3a856e55ab74289.js"></script>

Since this code only needs to be run once and as soon as the app starts we can create an additional helper class ensure this only gets called once.

<script src="https://gist.github.com/sthewissen/3445654d469285d257f89a9466e21991.js"></script>

This class then needs to be called before our function runs. Since functions are defined as a static class we can use the static constructor to call this code. Add a static constructor to each function that you want this code to run in and you're almost done!

<script src="https://gist.github.com/sthewissen/aae9b063832266c8f8d96b196eba7df2.js"></script>

### Defining an app setting containing your binding redirect

The last thing we need to do to tie this all together is to add a setting that defines the binding redirect. We can define this as a JSON string containing one or multiple redirects. To test this locally you can add this setting to your **local.settings.json** file. Make sure that you escape all the quotes because we're putting JSON into a JSON file here :)

<script src="https://gist.github.com/sthewissen/f842b48ce21447efd5984fd3fb7b155b.js"></script>

To run this live on Azure we need to add the app setting in the Azure Portal. Navigate to your Functions application and hit the **Application settings** button. Add an entry called **BindingRedirects** and add the same value that was added to the local settings file. However, do make sure that you do not escape the quotes in this one. Since this is not stored as JSON the backslash characters used to escape the string do more damage than they do good.

[![](/images/posts/azure.jpg)](/images/posts/azure.jpg)

And this should do the trick! If you need additional binding redirects you can add them to the setting and they should get resolved. Let's hope that this eventually gets fixed so we don't need this workaround anymore!
