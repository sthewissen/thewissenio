---
layout: post
title: Getting route data in ASP.NET Razor
date: '2016-01-26 23:11:45 +0100'
categories:
- Code Short
tags:
- .net
image: '/images/headers/routing.jpg'
---
When developing a web app using ASP.NET MVC you sometimes come across to make decisions based on the current page. A good example of this is when you're using Bootstrap and you want to add "active" classes to certain menu elements. You can find out where you are using the RouteData dictionary object. This contains the current area, action, controller among others. I personally use the extension method below to figure out where I am in my Razor pages.

Here's the code for the extension:
<script src="https://gist.github.com/sthewissen/9efe2865978a0fe09581.js"></script>