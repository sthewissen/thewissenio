---
layout: post
title: A farewell to our beloved Xamarin Insights?
date: '2018-01-21 10:49:57 +0100'
categories:
- Code
tags:
- xamarin
- appcenter
---

In October of 2014 Xamarin announced one of their new flagship products: Xamarin Insights, a real-time monitoring system that enables you to identify, report, and track issues that are impacting users. Now the time has come to say our goodbyes.

 

### It had to be coming at some point...

This one has been a long time coming. From [the announcement of the move over to HockeyApp](https://www.hockeyapp.net/blog/2016/03/31/welcome-xamarin-insights-users.html) in 2016 (which in my opinion never really took off from an Insights perspective) to then being integrated into the new [App Center](https://www.thewissen.io/crash-reporting-analytics-xamarin/) it was quite inevitable that one day Insights would be closing its doors for good. That day has now been officially announced as **March 31st**.

[![Reports in Xamarin Insights](/images/posts/InsightsReports-1024x683.png)](/images/posts/InsightsReports-1024x683.png)

At the time of its release I dove head first into Insights. It was a great solution to be able to spot errors in the app before users even reported them. By the time the user spotted it a fix was most likely already in place. The *Audience *feature also had a lot of use for me because it gave you a great overview of where my users came from, what devices they were using and which OS versions they were running on those devices. Xamarin Insights definitely looked the part as well and its looks still hold up today, more than 3 years later.

[![A stacktrace in Xamarin Insights](/images/posts/Insights-Stacktrace-1024x520.png)](/images/posts/Insights-Stacktrace-1024x520.png)

### So where do we go from here?

A lot of functionality present in Xamarin Insights has been ported over to Visual Studio App Center. However one of the most used features has not, causing a lot of issues for users that want to make the change. Insights supported the reporting of caught exceptions which enabled you to gracefully inform the user after an error occurred. App Center currently only supports unhandled exceptions meaning your app has to crash hard for the exception to be registered.

In a recent announcement Xamarin says that this feature will be added before they officially retire Xamarin Insights. That is definitely something to look out for! Here's hoping it works as great as it did in Insights.

<!-- wp:image {"align":"center","id":1121,"linkDestination":"custom","className":"is-style-default"} -->

[![The Users feature in Xamarin Insights](/images/posts/Xamarin-Identify-1024x509.png)](/images/posts/Xamarin-Identify-1024x509.png)

**Update:** I was asked about the source for this post. A few days ago it was communicated to all Insights users in an e-mail containing the following text:


> Hi Steven,
> 
> 
> 
> In March, 2016, we announced that Xamarin Insights would be merged into HockeyApp. Since that time, we have integrated HockeyApp's services and codebase into Visual Studio App Center, generally available as of November 15, 2017.
> 
> 
> 
> App Center will be the future of Microsoft’s mobile app analytics and crash reporting services going forward. It combines features from several mobile-focused development and lifecycle tools, including HockeyApp and Xamarin Insights, and its Analytics and Crash services are completely free.
> 
> 
> 
> In conjunction with this focus on a more coordinated developer service, we will complete the transition and shutdown process for Xamarin Insights on <span class="aBn" tabindex="0" data-term="goog_1892709559"><span class="aQJ">March 31, 2018</span></span>.
> 
> 
> 
> The team is working hard to close any remaining feature gaps between Xamarin Insights and App Center. We are currently focused on adding support for Handled Exceptions, which will be operational in advance of the Xamarin Insights shutdown.
> 
> 
> 
> **Recommended actions**:
> 
> 
> 
> *   As of <span class="aBn" tabindex="0" data-term="goog_1892709560"><span class="aQJ">March 31, 2018</span></span>, Xamarin Insights will be fully retired, you will no longer be able to collect or view any Xamarin Insights data, the service will be terminated.
> 
> *   If you have not already done so, please create a free Visual Studio App Center account at https://appcenter.ms/signup.
> 
> *   Familiarize yourself with the relevant App Center documentation and integrate the App Center SDK into your apps.
> 
> 
> 
> If you have transition questions, please contact us immediately at insights@xamarin.com so we can help you define a smooth, minimally-disruptive transition process during the remaining window of operation.
> 
> 
> 
> Thanks,
> The Visual Studio App Center Team
> 
> 

