---
layout: post
title: Checking out Mobile Center
date: '2017-08-22 10:25:22 +0200'
categories:
- Code
tags:
- xamarin
- appcenter
- azure devops
---



I've talked about [continuously building and deploying](https://www.thewissen.io/xamarin-devops-build-agent/) your mobile apps using VSTS before. But there's a simpler alternative in the works at Microsoft; **Mobile Center**. So let's have a quick look at it!







### Getting started with Mobile Center




If you're using VSTS it might seem like creating a build can get quite complicated fast. There are loads of tasks to choose from and tying the correct ones together isn't always as easy. [Mobile Center](https://mobile.azure.com) has some built-in features that greatly simplify these configuration steps so even my son of 4 weeks old could do it. Ok, maybe not right now but give him some time. With this post I'd like to show you the possibilities of the product so you can decide if it suits your needs. I already touched on the Analytics features [in a different post](https://www.thewissen.io/crash-reporting-analytics-xamarin/) so I won't be covering those again.



### Building your app




As soon as you create an app definition in Mobile Center you need to set up a build. To do so you can connect to a few popular repositories such as Github, VSTS and Bitbucket. Either will do just fine and it's great to see that you're not being restricted to just VSTS. After picking a repository type (I picked Github) Mobile Center asks you to locate the project you want to build.



[![Pick a project to build using Mobile Center](/images/posts/pickproject-1.png)](/images/posts/pickproject-1.png)



The whole process is pretty self-explanatory. Next up we pick a branch and we start configuring the actual build. I enjoy the wizard style setup of this which is great to get people new to this kind of stuff going within minutes. Select a branch and the following dialog will appear which requires you to set up just a few more things. All of these should not come as a surprise to you. Fill in the required fields and hit Save & Build to see your first build in action!



[![A basic build configuration in Mobile Center](/images/posts/configbuild.png)](/images/posts/configbuild.png)



[![Your app is building!](/images/posts/building.png)](/images/posts/building.png)



### Releasing your app




Mobile Center enables you to deploy your app to a variety of different destinations. One way to distribute your app uses distribution groups to separate your testers into logical groups. You can push a release to one or more of these distribution groups which will inform these users that a new version of the app is available. You can even use the Distribution SDK in your app to notify users of a new version right from within the app itself.



[![Distribute to user groups](/images/posts/distribute.png)](/images/posts/distribute.png)



Another awesome feature (in theory) of Mobile Center is the possibility to deploy to either the App Store or an Intune Company Portal. This feature does not look completely finished yet. There are mentions of deploying to the AppStore but when you add a connection it is nowhere to be seen. The Google Play Store is also absent which leads me to believe this part is not as polished as the rest.



### Conclusion




If setting up builds and releases using VSTS is too complicated for you and you're only looking for a platform that lets you continuously integrate and deploy your mobile apps then Mobile Center is great for you. When you require a bit more control and configuration options you are probably better off sticking with VSTS. However Mobile Center will replace products like Xamarin Insights and HockeyApp and it will gradually get more and more features. It also integrates with Xamarin Test Cloud. If you currently have everything you need set up in VSTS you're probably better off checking out again half a year from now. If you don't have anything set up yet, chances are you will get everything you need from Mobile Center so go check it out!

