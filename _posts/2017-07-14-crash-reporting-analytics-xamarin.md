---
layout: post
title: Crash Reporting and Analytics for Xamarin
date: '2017-07-14 21:58:23 +0200'
categories:
- Code
tags:
- xamarin
- analytics
---




Knowing what your app is doing after you've released it into the wild is very important. When it comes to Xamarin there are several products that offer functionality such as crash reporting and analytics.. So what should you be using these days?  





 







> **Note:** If you're still reading this today, you should now that what is referred to here as Mobile Center is now officially called AppCenter. Please take some of the information in this post with a grain of salt as some of it might be outdated.
> 
> 













### What used to be




For a while Xamarin offered their own solution called Xamarin Insights. This looked great and gave you the ability to view crashes and define events in your app that you could analyze to your heart's content. These events gave you insights into how much different parts of your app were being used. However Xamarin Insights has been on the fringe for over a year now as [their own page](https://www.xamarin.com/insights) will tell you without hesitation.







[![Insights is moving to HockeyApp](/images/posts/insights-700x322.png)](/images/posts/insights.png)




They're joining [HockeyApp](https://www.hockeyapp.net/) which is great news! HockeyApp is a platform that lets you distribute test versions of your application along with metrics and crash reporting. Even though their analytics side isn't as good looking as Insights it still sounds fun! Except for the fact that HockeyApp itself is also going to be shutting down at some point while they're getting ready for what they're calling the next generation HockeyApp: [Mobile Center](https://mobile.azure.com/).







[![HockeyApp is moving along to Mobile Center](/images/posts/hockeyapp-700x288.png)](/images/posts/hockeyapp.png)




### What should I be using today?




As described in the previous paragraph two of the tools people have been using are going away sometime in the future and a new contender for the crown has already been introduced by Microsoft. Having two products (HockeyApp and Xamarin Insights) for the same kind of functionality means its only logical to replace them however Mobile Center is more than the sum of its parts. It lets you connect to your VSTS instance and build your apps as well. It is less configurable than your own VSTS build pipeline though.





Some of the current features of Mobile Center:



*   Automatically build your app (e.g. on commit to a specific branch)

*   Test it on real devices using Xamarin Test Cloud (you can add your existing subscription)

*   Distribute it to beta testers in different distribution groups or production environments (AppStore, Play Store, InTune)

*   Collect crash reports and user analytics, including custom events

*   Add cloud-based user authentication and table storage in minutes

*   Push notifications with support for different audiences



As you can see it's quite the elaborate tool already and it's pretty much a one-stop mission control for your app. Since it's still in active development and constantly evolving it will most likely only get better.




### Let's focus on crash reporting




Since the basic idea of this post is getting some decent crash reporting we will zoom into that part of Mobile Center for now. It's pretty simple to set up so feel free to experiment with all the other features it offers. The first thing we need is to *define our app* which we do by going up to **New App** and filling in the required fields. As you can see Mobile Center also supports native apps made in Java, Swift or Objective-C. You can also see that HockeyApp is still very much alive in spirit by the *"This new app will not appear in HockeyApp"* message at the top.







[![Creating a new app](/images/posts/demo-700x356.png)](/images/posts/demo.png)




After creating the app definition there are only a few more steps that separate you from getting awesome stats.








1.  First of all you should be *adding a few NuGet packages* to your portable project and your platform specific projects which are the `Mobile Center`, `Mobile Center Analytics` and `Mobile Center Crashes` packages.

2.  Add the following using statements to your `App.xaml.cs`.
```
using Microsoft.Azure.Mobile; 
using Microsoft.Azure.Mobile.Analytics;
using Microsoft.Azure.Mobile.Crashes;
```

    
3.  Next up we need to let Mobile Center know that you want to start tracking. The line below goes in the `OnStart()` method in the `App.xaml.cs`. Don't forget to fill in the secret keys that Mobile Center gives you as soon as you create an app for each of the platforms you require.  
  

```
MobileCenter.Start("ios={You iOS App secret here}};" +
                   "uwp={Your UWP App secret here};" +
                   "android={Your Android App secret here}",
                   typeof(Analytics), typeof(Crashes));
```

    


And that's it. You're set to receive crash reports for your Xamarin Forms app. You can start generating crashes and the data you will receive will look something like the sample below. As you can see you can view things like the stack trace, affected devices, crash rate and the version of the app the problem occurred in. Very useful information!







[![An error logged in Mobile Center](/images/posts/error-700x355.png)](/images/posts/error.png)




### App usage




As soon as you've implemented the call to the Mobile Center SDK you also get usage information for free. In the Analytics section of Mobile Center you can view such statistics as:



*   # of active users and daily sessions per user

*   Session duration

*   Top devices

*   Countries and languages used

*   Version distribution amongst users



You don't have to do anything else to get this information and it can be quite crucial to making decisions about the future of your app. If you see a lot of users have a foreign language that you're not supporting yet then it might be worth investing in adding that language.







[![Basic stats about your app](/images/posts/events-700x354.png)](/images/posts/events.png)




### What about events?




Earlier in this post, I said you could also trace events throughout your app which can be defined by a single line of code. However, you are limited in what you are able to track. Currently, you can only track 200 unique events in your app and each event can have a payload that can contain a maximum of 5 custom properties. Note that there is a maximum of 256 characters supported per event name and 64 characters per event property name and event property value name. This is ideal when you need to have a bit more information about the event e.g. who triggered it. To log an event you can use the following line in your code:





`Analytics.TrackEvent("My very own event", new Dictionary<string, string=""> { { "User", "sthewissen" }, { "HasWifi", true });</string,>`





When you've implemented your events you can view them as soon as they occur in the Mobile Center events section. You get detailed statistics about their rate of occurrence per user or per session. You also get statistics based on the custom payload you provided. Using the sample above you would be able to get information about the percentage of users that HasWiFi was true for (100% in the sample :)).







[![Events-based stats in your app](/images/posts/events2-700x353.png)](/images/posts/events2.png)




### Conclusion




Mobile Center is a great stand-in for Xamarin Insights and provides more analytical information than HockeyApp does at this point. Microsoft is actively improving Mobile Center which means that new functionality is added on a regular basis. Installation in your app is a breeze so there's no excuse to not switch over to Mobile Center to get your analytics fix.


