---
layout: post
title: Travel broadens the mind...
date: '2019-04-03 11:53:08 +0200'
categories:
- Code
tags:
- xamarin
- xamarin.forms
- ui
image: '/images/headers/travel.jpg'
---

They say that seeing new places can work wonders for your creativity. I've recently gone on a trip to Seattle, visiting the Microsoft MVP Summit. With half an hour to kill in between sessions, I started tinkering with another UI sample in Xamarin Forms. This is the result of that.

By now you must know how these posts go, so I won't be going into a lot of the details. I find a cool looking UI and replicate it in Xamarin.Forms. Everything is open source on Github and I will be picking out some things that are special about this and highlighting how they're done. Sounds easy enough right?

![](/images/posts/travel_app_dribbble_2x.jpg)

The inspiration for this post came from the above shot found on [Dribbble](https://dribbble.com/shots/6079769-Travel-App-Exploration), which was made by [Panji Pamungkas](https://dribbble.com/panjipam). Not all that you see is part of this little sample, such as the custom tab bar and even though that would be a very fun avenue to explore it's also a very complicated one. I still want to have fun while doing this. Implementing that would start to look like this was work ;)

### The rounded corners

One of the first things that stands out is the use of rounded corners. The header picture has a nice rounded corner on the bottom right with a content panel on top of that, which also has two rounded corners on opposite sides.

This is where my recently developed `PancakeView` comes in handy. It's essentially a layout element (based on `ContentView`) that comes with built-in support for background gradients, rounded corners, borders and shadows. It's a perfect fit for this part!

[![](/images/posts/droid-1.jpg?style=halfsize)
*Our end result on Android, with a minor quirk :(*](/images/posts/droid-1.jpg)

Unfortunately, this is where we run into a small issue. As you can see the bottom right corner isn't rounded off correctly on Android. This is due to a limitation on Android where, if you want to clip the content inside of a view (the image), all of your corners need to be rounded using the same radius. However, this is not an issue for the white overlay panel because it has no content inside of it that overlays the corners. On iOS this is also not an issue.

<script src="https://gist.github.com/sthewissen/9424cf6db2c94dc0ee7c9960a5cb1811.js"></script>

**Update:**
_An alternative option for this is using FFImageLoading Transformations. This is a library on top of FFImageLoading that lets you render images using individual rounded corners. The code for this can be found in [this Gist](https://gist.github.com/sthewissen/07e8a50c04e7ac2989abf4195f59b2f0)._

### The new CollectionView

This app has two horizontally scrolling sections with content, one for the "Hot places" and one for "Categories". This can easily be done by using a `ScrollView` and `BindableLayout`. However, if you're willing to venture into the preview bits you will find the `CollectionView` which is also equally capable of pulling off this kind of layout.

<script src="https://gist.github.com/sthewissen/fef58c5c6f77944b5ddc6424ecffe7e6.js"></script>

You might be wondering how to use these preview bits. Simply update your Xamarin.Forms NuGet package to the latest 4.0 preview version and add the line shown above to your `AppDelegate.cs` and  `MainActivity` (before `Forms.Init()` call). After that you're good to go!

<script src="https://gist.github.com/sthewissen/5e9da5af2d7778737231d399d3bbfd5e.js"></script>

Keep in mind though, these are preview bits, so there may be things in there that don't entirely work as they should. Don't go shipping this in a production app just yet ;)

### Creating a dark semi-transparent overlay

You may not even notice this subtle effect on the "Hot Places" images, but there's an overlay of a black fade from the bottom to the top on each of them. It adds a bit of character and uniformity to the images while also providing a good backdrop for the text to become more legible. So how's that done?

[![](/images/posts/ios.png?style=halfsize)
*The end result on iOS, fancy pants!*](/images/posts/ios.png)

Here's where good ol' `PancakeView` comes back in again. As mentioned before it also has a gradient background feature, which we can leverage to achieve this effect. To get this to work we need to cleverly stack two `PancakeView`s on top of one another. One contains the actual image and creates rounded corners. The other one is overlayed on top of that and creates a gradient background going from black to transparent.

![](/images/posts/layercomp.jpg)
*The composition of layers creating the overlay effect*

The shot above shows how these two `PancakeView`s are layered on top of one another to create the effect. It's a really simple solution but it adds to the overall experience. The code for it is this little snippet right here:

<script src="https://gist.github.com/sthewissen/18cb7dadb03db35c7639b32a0be2d808.js"></script>

### Let's have a chat about icon fonts

If you're not using an icon font yet to render out all of your icons you really should consider it. There are numerous of these fonts out there such as [FontAwesome](https://fontawesome.com/icons) that you can freely use which offer you a wide range of icons. I use FontAwesome to create the notification bell icon, the rating stars and category icons in this UI sample.

But why use a font instead of images? Fonts are vector-based which allows you to infinitely scale them without any loss of quality. It also allows you to use all 16 million colors available to you to tint your icon, whereas using images you'd have to create separate images for all of these occasions.

Using custom fonts is always a pain in the ass, so I recently reached out to Matthew Robbins of [MFractor](https://www.mfractor.com/) fame to see if we could improve that. Within weeks he came up with this brilliant solution: a Font Importer! This is now part of MFractor and greatly simplifies the workflow around using custom fonts, so you should really give it a try!

[![](/images/posts/Screenshot-2019-04-03-at-09.30.29.png)
*The new Font Importer in MFractor*](/images/posts/Screenshot-2019-04-03-at-09.30.29.png)

### Code & tools

You can find the code here: [https://github.com/sthewissen/KickassUI.Traveler](https://github.com/sthewissen/KickassUI.Traveler). If there's something in there that you think can be done better in a different way or found a bug; feel free to submit a PR. I'm always looking to learn :)

The following tools were used to create this app:

*   MFractor – Productivity tools for Visual Studio Mac – [https://www.mfractor.com/](https://www.mfractor.com/)
*   LiveXAML – Live simulator updates for your XAML code – [http://www.livexaml.com](http://www.livexaml.com/)
*   PancakeView - Layout element with additional features - [https://github.com/sthewissen/Xamarin.Forms.PancakeView](https://github.com/sthewissen/Xamarin.Forms.PancakeView)