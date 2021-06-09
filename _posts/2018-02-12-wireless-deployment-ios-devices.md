---
layout: post
title: Wireless Deployment of Xamarin apps to your iOS devices
date: '2018-02-12 21:30:11 +0100'
categories:
- Code
tags:
- xamarin
- ios
- tools
---



If you're anything like me you probably have an iPhone cable near you at all times when working on a Xamarin app. It will probably look like it has seen better days but it still works doesn't it?







Because of the frequent use my iPhone cables start to break at some point but I usually carry on like a trooper. Some scotch tape also helps to make some last-minute lifespan extensions. When the cable eventually breaks I'm usually screwed because I never thought to buy a new one.



### Introducing Wireless Deployment




All of the above is now a thing of the past with the introduction of **Wireless Deployment** in Visual Studio for Mac. And the beauty of it is that it takes you no additional effort to configure in VS. It's currently only available in the Preview version ([VS for Mac 7.4 Preview 2](https://docs.microsoft.com/en-us/visualstudio/releasenotes/vs2017-mac-preview-relnotes#release-date-january-10-2018---visual-studio-2017-version-74-preview-2-740839) and Xamarin iOS 11.8) and only takes a bit of configuration in Xcode. However you can use to debug with your feet up on your desk and no cables to worry about! Breakpoints will be hit and everything will work as if the device is connected through USB.



[![](/images/posts/networkdebug.jpg "Wireless debugging on iOS")](/images/posts/networkdebug.jpg)



How do you get it? Open Xcode and go up to **Window > Devices and Simulators**.  Make sure you've connected your device through a USB cable to be able to enable it to be discovered on the network. Once you see your device tick the **Connect via network** box and wait for it to connect to the network (as indicated by the globe icon. Disconnect the USB cable and it should show up in Visual Studio for Mac as a connected device!



***Update:** As pointed out to me on Twitter by Pierce Boggan (Microsoft): It even works on Visual Studio for Windows which makes it even more awesome than it already is :)*



***Update 2:** Now with added [documentation](https://developer.xamarin.com/guides/ios/deployment,_testing,_and_metrics/wireless-deployment/)!*

