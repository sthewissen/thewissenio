---
layout: post
title: Xamarin.Forms ListView grouping and styling the jump list
date: '2017-08-30 15:24:51 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
---

When creating a Xamarin Forms application there's almost no getting around using a `ListView` component at some point. When you have a lot of items to display you might even consider adding `ListView` grouping. But how does that work?

### Getting started with ListView grouping

To start grouping the items in your ListView you will first need a key to actually group them on. This can be the first letter of a `string` in your object but might as well be an `enum` or `boolean`. Since people have been doing grouping in ListViews long before you're reading this there are already some useful helpers available. So let's install [this handy NuGet](https://www.nuget.org/packages/Refractored.MvvmHelpers/) called **MvvmHelpers**! This gives you access to the very useful `Grouping` class (which is pretty simple yet effective in its own right).

Another helpful class that we get from this NuGet package is the `ObservableRangeCollection` which provides our bindings with notifications when items get added, removed, or when the list is refreshed. We need to define a variable that will contain our grouped items. This is what we'll be binding our `ListView` to.

<script src="https://gist.github.com/sthewissen/2b9bb8c218de88c2dd6911356da562eb.js"></script>

With the collection to store our grouped data in in place we can easily adjust our existing data retrieval code. To do this in a pretty simple fashion we can leverage the power of LINQ to create our grouping:

<script src="https://gist.github.com/sthewissen/9c87d58ad8605e9c7f340107e3d32ed6.js"></script>

What this does is group by the first letter of each item using the LINQ `group` statement. Because we use the built-in `group` query we also get a key value that we can provide our own `Grouping` object with. All items with the same key are put into the itemGroup variable and are added to our grouping. Lastly we update our `ListView` to use the correct items and group on our key value.

<script src="https://gist.github.com/sthewissen/8a5247de1fc85ac9bd2acdf92d5c71f8.js"></script>

And there we have it. A simple grouping of items based on the first letter of their name with just a few lines of C# code and a bit of XAML interface code. The screenshot below shows this code in action in our upcoming [Have I Been Pwned](https://haveibeenpwned.com) app.

[![ListView grouping in HIBP](/images/posts/hibp-320x570.png)](/images/posts/hibp.png)

### Adding a jump list and styling it

Have you ever seen that little list on the side of the ListView that lets you jump to items starting with the letter you tapped on? That's a jump list or as iOS calls it an "index list" which lets you quickly move to the section you're looking for. Enabling this list is pretty straightforward in Xamarin Forms. It only involves setting the ` GroupShortNameBinding` property on your `ListView`:

<script src="https://gist.github.com/sthewissen/a8b93ea3606b8e3dea61ed1c317bc047.js"></script>

On Android there is no such thing as a jump list so you'll have to roll your own if you need one. Xamarin Forms doesn't expose any functionality to style the list on iOS which is why we need a custom renderer for that. Luckily the renderer isn't that complicated once you figure out what you need to be changing.

<script src="https://gist.github.com/sthewissen/006329079d51fbd8535b944a02419508.js"></script>

### Conclusion

Adding `ListView` grouping is pretty straightforward but can really help your users keep an overview of the items you're presenting to them. It only takes a few lines of code you can have this up and running in a matter of minutes!
