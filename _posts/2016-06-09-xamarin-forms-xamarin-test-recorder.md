---
layout: post
title: Xamarin.Forms and the Xamarin Test Recorder
date: '2016-06-09 22:17:11 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
image: '/images/headers/phonebooths.jpg'
---

One of the recent additions to the Xamarin family of products is the Xamarin Test Recorder. What this nifty little tool does is allow you to record your UI tests while you're navigating through your app and export them into either your codebase or the Xamarin Test Cloud. If you're not familiar with what the Test Cloud is it's basically a warehouse full of devices in Denmark that you can get computing time on to test your app. Let's face it, no one has 2000+ physical devices to test on so this offering paired with an easy to use recorder app can help definitely help you out when you want to put an app in the AppStore. Currently the Test Recorder is still in preview on the Mac so you probably should use it with caution, but let's be brave and take it for a spin shall we?

### No Windows Phone please...

The first thing you'll notice when you try to install the [Xamarin Test Recorder](https://www.xamarin.com/test-cloud/recorder) is that there are two versions of it. The Mac version will let you record tests for iOS and Android whereas the Windows version only allows you to record for Android. There is no version for Windows Phone and there probably never will be because let's face it, that platform is dead. After you've installed the Recorder you will open up to a screen similar to the one below (which is the Mac version obviously). There's not a whole lot more of a UI to learn so this introduction will be quite short (but sweet).

![testrecorder](/images/posts/testrecorder.png)

You start off by selecting a device that you want to use to record the test on. This can be a simulator or an actual physical device. Next up is selecting which app you would want to record from. You can pick one from the list or use the **Open...** option to pick an app file on your file system to run. The test recorder will start the app on your device or boot a simulator and you're ready to go. After your app has booted you can hit record and get going. I recorded a quick session of the login screen of one my apps below.

![boodschappielogin](/images/posts/boodschappielogin.png)

### Start recording!

As you can see it records all your taps, any text that you entered and also your scroll gestures (which I did not perform in this sample). Immediately some things stand out. On the left hand side you can see the steps you took, which you can then tweak. You can enable taking a screenshot at that step or add additional criteria to certain steps.

By default a tap on a field generates a line in the test script where it simple takes the first field. The second field tap adds an indexer to indicate the second field. Another thing you might notice is that it uses UIButton, UILabel and other iOS specific controls which means that the test isn't particularly cross-platform when you put it into your project. Another caveat worth mentioning is that it finds things to tap on by the Text property which could be different if you're running multi-language apps.

The right hand side of the screen shows the UI test it generates in C# code. You could copy this over to your solution, create a class to hold the UI test and feed it into your Continuous Integration pipeline. Another option is to run these tests at a later time on a simulator or device. Since they're in your project you can do whatever you want with them.

### So what about Xamarin Forms?

I mentioned that the tests that the Text Recorder generates aren't quite cross-platform. That's not a strange thing though since the binary that is being created by Xamarin behaves in exactly the same way as a native Objective-C app built by Xcode would. In the traditional Xamarin approach your best option is probably to create separate Droid and iOS UI tests and feed those into Test Cloud. Luckily with Xamarin Forms the UI layer is also shared and we can further abstract that accordingly.

In Xamarin Forms just about every UI element has a property called the `AutomationId`. Setting this gives the control a unique ID that we can use in our UI tests. Looking at the simple login below you can see that I've added the `AutomationId` to both the root level element (the Grid), both of the text fields and the button.

<script src="https://gist.github.com/sthewissen/657760e02ad528a270c52d9fbdf93102.js"></script>

This is all that is needed on the UI side of things to be able to write your UI tests. You can still use the test recorder for this but it will take some manual labor to remove the platform specific code and replace these calls with the `AutomationId` code. Here's an example of how such a test would look for this simple login page:

<script src="https://gist.github.com/sthewissen/34bf0419d82c1c54e62a6a60b01d79f7.js"></script>

For the `BasePage` class I would like to refer to [James Montemagno's Evolve sample app](https://github.com/xamarinhq/app-evolve/blob/master/src/XamarinEvolve.UITests/BasePage.cs) which is also a great source to get started with this. Before these tests will run when you put them up on the Test Cloud platform there's a specific line of code that you need to add to both the Android and the iOS project. This piece of code is run on app initialization and hooks up the `AutomationId` property to an internal app specific property that Test Cloud uses to locate the UI elements. On iOS this code is called from the `OnFinishedLaunching` of your `AppDelegate.cs` class.

<script src="https://gist.github.com/sthewissen/7210d9efa94f7b0a7dc4131324fd1448.js"></script>

On Android the following piece of code should be called from the OnCreate in the MainActivity:

<script src="https://gist.github.com/sthewissen/7e58e3612619697bfd2def7c0533bbd0.js"></script>

And it's as simple as that. The Xamarin Test Recorder is a simple tool to use and can save you some tedious typing if you have a lot of tests or if you simply want to get the hang of how to type your UI tests. Using it for Xamarin Forms still takes some adjusting but a lot of the code that the Test Recorder produces can still be used even in this type of project. Go check it out!
