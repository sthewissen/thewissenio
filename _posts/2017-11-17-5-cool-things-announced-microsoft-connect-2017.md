---
layout: post
title: 5 cool things announced at Microsoft Connect 2017
date: '2017-11-17 13:35:48 +0100'
categories:
- Code
tags:
- xamarin
- xamarin.forms
- azure devops
---

Microsoft Connect 2017 has come and gone and a lot of new awesome stuff was announced across the board. I'm partial to mobile development using Xamarin and the whole Devops process using VSTS, so here’s 5 things from the mobile/devops space that I thought were pretty cool! 

In this post:

*   Hosted macOS build agents in VSTS
*   Xamarin Live Player
*   .NET Embedding
*   Visual Studio App Center
*   Gated releases on VSTS

### Hosted macOS build agents in VSTS

I made [a blogpost on creating your own Mac build agent](https://www.thewissen.io/xamarin-devops-build-agent/) for your mobile apps a while ago. It involves having a physical Mac machine somewhere in your network that acts as a build host for your VSTS continuous integration.

[![The macOS hosted agent on VSTS](/images/posts/hostedagent.png)](/images/posts/hostedagent.png)

At Microsoft Connect it was announced that this is a thing of the past. You’re now able to use a Mac build host located in the cloud at Microsoft. This means that no more additional hardware is needed to CI build your Mac apps and that is an awesome thing. It saves you a lot of effort and time installing Xamarin updates and keeping that additional Mac hardware up-to-date which is now all handled by Microsoft :)

### Xamarin Live Player

The Xamarin Live Player is a tool that has been on my radar for a while now. It enables you to directly see changes you’ve made in your XAML files in the running app on the device. It now also seems to support changes made in code and it seems to work in an instant without the need for constant waiting for compiling and deploying to the test device.

[![The Xamarin Live Player](/images/posts/live-player-updated-bb6hxm8t.gif)](/images/posts/live-player-updated-bb6hxm8t.gif)

Every time I see it this tool gets better and better. For now though I’m still using [LiveXAML](https://www.livexaml.com) at least until the Live Player is a bit more stable. I’ve tried it on multiple occasions but haven’t been able to get it to work for me yet. Don't let my experience hold you back though! Be sure to give it a try because this has the potential to become one of the best Xamarin tools you'll be using on a day-to-day basis!

### .NET Embedding

This is one of [the big ones](https://developer.xamarin.com/guides/cross-platform/dotnet-embedding/). In the near future we will be able to create a component using Xamarin and use that from Objective-C or Java code. You can even build the UI using Xamarin! The sample James showed detailed creating a custom component in Xamarin and integrating that in the Objective-C-based Kickstarter mobile app.

[![.NET Embedding explained](/images/posts/C_p26e9WAAAsG-J-1024x577.jpg)](/images/posts/C_p26e9WAAAsG-J.jpg)

Xamarin announced a tool called the [Embeddinator-4000](https://github.com/mono/Embeddinator-4000) earlier this year which is a big part of making this whole process possible. However as much as I think that this is awesome on a technical level I'm still unsure if I'll ever use it.

### Let's elaborate on that a bit more...

I totally see the value of this when it comes to making the .NET platform more accessible from worlds that are not traditional .NET environments. After all that's what Xamarin has been doing as long as they're around. If you have a native iOS or Android app and want to gradually make the change to .NET this might really help you.

On the other hand I do feel that it might re-introduce a concept that Xamarin has been fighting against for the last few years. They used to call it the "silo approach" to app development where you have an Objective-C codebase and a Java codebase which means you have two separate worlds you need to support. Xamarin sought to unite these two in .NET with the thought of creating a single codebase for both platforms but this feature feels more like they're adding .NET into the mix as a third flavour.

As a developer that is all-in on using Xamarin with C# I will most likely never come across a situation where I have to use this feature. Let me state once more that I think that it's an **awesome** achievement to get this to work from a technical point of view but for now I remain skeptical on the practical situations you can apply this to. If anyone has some arguments in the matter that can sway my opinion I'd love to hear them :)

### Visual Studio App Center

Microsoft toggled the switch, slapped a price tag on it and what used to be [Visual Studio Mobile Center](https://www.thewissen.io/checking-out-mobile-center/) is officially out of preview! Don't look for Mobile Center anymore though because it is now known as Visual Studio App Center. It still offers you the same great functionality though:

*   Crash reporting & analytics
*   Continuous integration builds
*   Continuous deployment to groups of testers / store
*   Automated testing using the device cloud
*   Targeted push notifications

All of the above functionalities are available for projects created in Swift, Objective-C, Java, Xamarin and React Native so you have a huge range of options to get started with mobile development!

### Gated releases on VSTS

[Gated releases](https://docs.microsoft.com/en-us/vsts/build-release/concepts/definitions/release/approvals/gates) is a new feature in VSTS. This enables you to ensure that you're practicing safe releases on your software. By enabling gates you can have your release pipeline monitor data from Application Insights to determine whether or not to proceed with a release to the next environment. You can even run arbitrary code in the form of an Azure Function or a web API to determine whether a release is fit to be promoted.

[![Gated releases in VSTS](/images/posts/gated-releases-01.png)](/images/posts/gated-releases-01.png)

Additionally you can check forcreated work items to determine if a release is bug-free and can be released. If a work item matching your conditions is found the software won't be deployed any further which enables you to fix the issue before a your users get the new version. You set up these gates in the Pre-deployment conditions of an environment in VSTS' Release Management.

### Microsoft Connect bonus item: Xamarin.Forms 2.5

Ok, I couldn't stop at just 5 items. I'm sorry. So here's one more bonus item to end this post with: Xamarin.Forms 2.5 is released. Besides the aforementioned .NET Embedding this release covers a few additional big things. One of these is layout compression and fast renderers. This feature enables you to optimise your layout for performance. Layout compression allows you to specify unnecessary nesting and allows Xamarin.Forms to opt-out of creating that layout view which in turn decreases the amount of layout passes needed to create the layout on the screen.

Another new feature in Xamarin.Forms 2.5 is the XAML Standard which is now in preview. The Xamarin.Forms team is working together with the Windows team on defining a single XAML standard that enables XAML files that support it to be interchangeable. This means you can share your UI assets with any other XAML Standard compliant platform which gives you even more code-reuse!

