---
layout: post
title: Building a cryptocurrency trading bot using Azure &ndash; Part 2
date: '2017-11-14 16:36:57 +0100'
categories:
- Code
tags:
- azure
- azure functions
- cryptocurrency
---



In [part 1 of this tutorial series](https://www.thewissen.io/building-cryptocurrency-trading-bot-using-azure-part-1/) we built a trading bot using an Azure Function. In this 2nd part we will create a simple mobile app to keep track of what our bot is doing. Since it's still a robot we also want to control it a bit simply to prevent our robot overlords from taking over.







This post will cover a few different topics:



*   Adding an iOS mobile app

*   Adding HTTP endpoints for our mobile app to gather trade data from

*   Adding push notifications to the mobile app



The topic of creating a mobile app is not within the scope of this post although I reference it shortly. The main focus of this post is hooking it up to our bot through Azure Functions.



### Creating a mobile app




To create the mobile companion app to the bot I use Xamarin Forms. This is a really simple framework to create cross-platform native apps and suits this project quite well. It's also what I'm used to using for my app development and if you expected anything else you haven't been reading this blog ;) This is the mobile app I came up with for this post:



[![Mobile companion app for the trade bot](/images/posts/app-1024x888.jpg)](/images/posts/app.jpg)



Like I said before I will not be going over how to create a Xamarin app in detail in this post. There are more than enough resources on that available on the web. You're free to create the mobile app as  you see fit. The interesting part here is how we can leverage Azure Functions to retrieve data from our bot and send commands to it.



### Getting the data from the bot




The mobile app needs to be able to pull in the trade data of our bot. In the previous post I stored this data in Azure Table Storage so querying it isn't too complicated. The only thing we need to do is create a few new Azure Functions that use an `HttpTrigger`. These Azure Functions basically act as web API endpoints in the cloud that spit out our trade data for the app to use. These functions are only started when people use them so you only pay for the actual usage. This is a great technique for performing simple API-like tasks in the cloud.



<script src="https://gist.github.com/sthewissen/d85241d8341afd9af7929383dd1f94ea.js"></script>



We need a few of these for different functionalities in the app that we're creating:



*   `GET` Retrieve our current active trades

*   `GET` Retrieve our trade history

*   `GET` Retrieve the settings our bot is currently using

*   `POST` Direct sell a trade

*   `POST` Register our device for push notifications



Source code for all of these is available on the [Github page](https://github.com/sthewissen/Mynt) for this bot.



### Notifications




We want to be able to be notified of a trade. This sample will implement push notifications but by abstracting the notification manager into an interface we can plugin different types of notifications. If you want to receive an e-mail or a message in a Telegram chat you can simply implement the `INotificationManager` interface and plug it into the trade manager upon initialization :)



<script src="https://gist.github.com/sthewissen/ad53bf8a302ab4ace6eef91e5299b51e.js"></script>



By registering our device for push notifications we can receive a notification when we enter or exit a trade and in the case of an exit we can also notify the user of the amount of profit of that trade. To easily implement push notifications we can make use of an Azure component called [Notification Hubs](https://azure.microsoft.com/en-us/services/notification-hubs/). Registering our device becomes as simple as calling an Azure Function:



<script src="https://gist.github.com/sthewissen/3fcdc2c59ccf331e2ed4d3848c718837.js"></script>



### Conclusion




We have created a companion app for our trade bot. This is our main interface to see what is going on with our trades and it enables us to exercise some form of control over it. Now lets hope our bot gets us some nice profits :) Need more information? You can always leave a comment or ask me on Twitter. As usual the code can be found on [Github](https://github.com/sthewissen/Mynt).

