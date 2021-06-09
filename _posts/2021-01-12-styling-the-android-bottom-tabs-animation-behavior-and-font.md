---
layout: post
title: Styling the Android bottom tabs animation behavior and font
date: '2021-01-12 19:12:00 +0100'
image: '/images/headers/tabs.jpeg'
categories: Code Short
tags: xamarin xamarin.forms ui
---
I recently used the bottom tabs navigation for Android, which comes with a fancy animation scaling the selected item. But what if you don't want that?
Making your apps look similar on all platforms is what most people are trying to achieve these days. For iOS, the Xamarin.Forms `TabbedPage` puts a tab bar at the bottom of your page. By using the `SetToolbarPlacement` platform-specific for Android you can mimick that behavior for Android. Awesome! Now it should all look the same, right?
### Unfortunately not...
When first getting the bottom tabs on Android you will notice that selecting a tab comes with a fancy animation where it scales the active item. Also, there seems to be no API available on Xamarin.Forms to change the text size. So how can we do this? Let's explore!
![The active tab is bigger than the other... Not cool!](/images/posts/tabs_1.png)
*The active tab is bigger than the other... Not cool!*
A lot of the visual things in Android are controlled by resources. These can typically be found inside our app's Resources folder. If you look in there for an app you're working on, you can probably find things like colors, styles, etc. A different type of resource, however, is the so-called **dimensions**. These [indicate the size of an element](https://developer.android.com/guide/topics/resources/more-resources#Dimension) on the Android platform. We can leverage this system to our advantage to style our tab bar.
### Styling the bottom tabs
The first thing we need to do is create a new XML files (if it doesn't exist already) in our **Resources > values** folder called **dimens.xml**. After pasting in the following all that's left is tweaking the values to your own liking!
<script src="https://gist.github.com/sthewissen/44ecc8f066fa1cc60fb53c510dfaa639.js"></script>
![Uniform Android tabs, huzzah!](/images/posts/tabs_2.png)
*Uniform Android tabs, huzzah!*
And there we go, uniform Android bottom tabs! So the next challenge I had was to change the font to a custom font. However, because there's nothing available out-of-the-box to do so, we will need to resort to a custom renderer. Here's the one I've used for it:
<script src="https://gist.github.com/sthewissen/e6c0daa16639c6181f6ce9a7d61ead33.js"></script>
What it does is grab a reference to the `BottomNavigationView` and subsequently, loop through its items setting the font of the text labels to an existing custom font. Ensure this font file exists in the Android project's `assets` folder and is marked as an `AndroidAsset` in its `Build Action`.
![Custom font enabled!](/images/posts/tabs_3.png)
*Custom font enabled!*
### Conclusion
In this post we tweaked the Android bottom tab bar by getting rid of its default animation while at the same time also offering an option to adjust the font and icon size based on an XML configuration. We also explored changing the font which does unfortunately require a custom renderer. Either way, we're one step closer to making our apps look the same across all platforms!