---
layout: post
title: Embedding a YouTube feed in Xamarin.Forms
date: '2017-06-20 21:09:38 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
- ui
image: '/images/headers/youtube.jpg'
---

When building an app for a customer that has an active YouTube channel you might get the requirement to embed their YouTube channel into the app. This is actually simpler then you might think. Since YouTube is a Google product you can bet your life's savings on the fact that there's an API for it.

### Creating a new Xamarin Forms project

For this article, I'm assuming that you're familiar with what Xamarin Forms is and how it works. So without further ado let's jump into Visual Studio. Start off by creating an empty Xamarin Forms solution. I chose the **Portable Class Library** variety for this project. Give it a fancy name and hit **Create**. I named mine *YouTubeEmbed* which isn't all that original but it does the trick. Your solution explorer window should look something like this when you're done.

![The solution explorer after creating a blank Xamarin Forms app.](/images/posts/solutionexplorer.png)

### Getting your API keys

Most API's won't simply let you pull in their data. The YouTube API is no different. To retrieve data you will need to register an API key which you need to pass in with every request. That way YouTube knows that you're calling their API as a validated user. To get such an API key you can go to your Developer Console and register it. First, we need to **Create a new project** in the API console which we can do where it says **My project** in the top-left corner. When that is said and done we can search for the **YouTube Data API**, which is the one we're going to be needing for this project.

![](/images/posts/apis.png)

 After you've enabled the **YouTube Data API v3** you will see a API key in the **Credentials** section. This is the key we'll be using in this sample. I removed it from the screenshot since you need to make your own key :) Copy it over to your Xamarin app.

![Enable the YouTube API](/images/posts/enableapi.png)

![Getting your API key](/images/posts/apikeuy.png)

### Calling the API and retrieving the data

Since the YouTube API is REST-based we need a URL to call and retrieve our data. That URL is [documented](https://developers.google.com/apis-explorer/#p/youtube/v3/youtube.videos.list) pretty well and for the scope of this post it looks like this when we put it into a constant in our project.

<script src="https://gist.github.com/sthewissen/bee8e071f06a97b2b6b3e1f31da8e536.js"></script>