---
layout: post
title: 'Deploying Azure Functions using VSTS: a simple solution'
date: '2017-10-20 23:00:30 +0200'
categories:
- Code
tags:
- azure
- azure functions
- azure devops
image: '/images/headers/lightning.jpg'
---

I recently started exploring the wonderful world of Azure Functions and while they are a great tool to move towards a cloud-based architecture I started to wonder... How should I be deploying Azure Functions using my existing VSTS setup? 

### Deploying Azure Functions using VSTS

Since Visual Studio 2017 is now supporting [Azure Functions](https://azure.microsoft.com/en-us/services/functions/) we can create functions using C# class libraries. First you define your triggers and your bindings using built-in attributes to decorate your functions with. This is then converted into the **function.json** format that defines your function.

You can deploy your functions using **Right click > Publish** from Visual Studio but there's a saying for that these days. *"Friends don't let friend right click and publish"*. And rightfully so. In a world where continuous integration is becoming the norm you should not be doing that. Instead you should look at either the existing continuous integration features of Azure Functions or use VSTS to deploy them for you.

So how do we use VSTS if we're deploying Azure Functions? It turns out the answer is a lot simpler than it seems. However it is a bit of a hidden "feature". There is a new build template called **ASP.**NET Core (.NET Framework) that we're going to use for this. Let's create a new build definition and select that template.

[![Deploying Azure Functions using VSTS](/images/posts/Screen-Shot-2017-10-20-at-22.14.11.png)](/images/posts/Screen-Shot-2017-10-20-at-22.14.11.png)

Even though Azure Functions are not running on ASP.NET Core this template gives us a good starting point because it builds our Azure Functions project for us and puts a zip file containing all we need in our staging directory.

### Releasing your Azure Function into the wild

With our build taken care of we can set up our release. To do so, click on the **New Definition** button in the **Release** tab.

[![Deploying Azure Functions using VSTS](/images/posts/Screen-Shot-2017-10-20-at-22.24.07.png)](/images/posts/Screen-Shot-2017-10-20-at-22.24.07.png)

Next give your release a nice name and add a task called **Deploy Azure App Service** to the release definition. This task ensures that your Azure Functions App, which runs as an App Service, can be deployed.

[![Deploying Azure Functions using VSTS](/images/posts/Screen-Shot-2017-10-20-at-22.24.19.png)](/images/posts/Screen-Shot-2017-10-20-at-22.24.19.png)

There is one small thing we need to configure in this task. First select your **Azure Subscription** and subsequently the **App Service name** for the Azure Functions project we're going to be deploying to. By default this task doesn't look in the same directory that we just built our project into. To change this modify the **Package or folder** variable to `$(build.artifactstagingdirectory)/**/*.zip`. Hit Save and queue your build and watch the magic happen!

[![](/images/posts/Screen-Shot-2017-10-20-at-22.25.26.png)](/images/posts/Screen-Shot-2017-10-20-at-22.25.26.png)