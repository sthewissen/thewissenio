---
layout: post
title: Using custom fonts in Xamarin Forms
date: '2016-02-15 11:36:31 +0100'
categories:
- Code
tags:
- xamarin
- ios
- android
- xamarin.forms
image: '/images/headers/flags.jpg'
---

Xamarin Forms is a great platform for quickly making multi-platform mobile apps. Xamarin markets it as a platform that isn't quite suited for creating complex UIs but that doesn't necessarily have to be the case. When it comes to branding your app using a custom font can go a long way. 

The problem that arises is that both Android and iOS handle custom fonts in a fundamentally different way. So let's find a way that works the same way for both shall we?

### Adding a custom font in iOS

Let's start with iOS. To add our custom font to our application we simply add the font file to the **Resources** folder. You can use subdirectories if you want to (I used Fonts in this sample). Once you add the font(s) you'll have to ensure that the **Build Action** for each font is set to **BundleResource** and **Always copy** is set as the **Copy to output directory** property.

After adding our fonts to the application we will have to tell iOS where it can find these custom fonts. That is done by editing the Info.plist file. Open it up in the plist editor and add the **Fonts provided by application** key. Add all the fonts you want to use as separate keys within the array.

When using the custom font in iOS you have to use the actual (internal) font name. This is not necessarily the same as the filename. An easy method to figure out the correct name you have to use is to write all the installed fonts to the debug window when the app is started. You can use the following gist to do so.

<script src="https://gist.github.com/sthewissen/0105914b4c63fd532fd2.js"></script>

### Moving on to Android

In Android we run into a different problem. Xamarin.Forms for Android doesn't expose the ability to set the font to a custom font file, so we will have to resort to custom renderers. A sample implementation for a Label is shown below. When writing the renderer for the Android platform, we have to create a Typeface instance that references the custom font file that has been added to the **Assets** directory of the application (with Build Action: **AndroidAsset**). The custom renderer checks if it can find a font file with a given filename (which we pass in through the FontFamily property) and if it finds one it uses it. If it doesn't it simply falls back to the default font.

<script src="https://gist.github.com/sthewissen/217ce180f2b7532c0546.js"></script>

### Tying it all together

The last part we need to do is telling our Xamarin Forms pages which font we want to use. The important part of achieving this across both platforms is simply making sure that the FontFamily we set matches the iOS font name we found earlier using the font loop in the AppDelegate class. For Android to keep up we simply have to name the .ttf file after the iOS font name. When we set a FontFamily in our Xamarin Forms page iOS uses that to find a font matching it based on the font name. On Android our custom renderer tries to match it to an actual file name in the Assets folder so we simply have to make sure these names correspond with one another.

<script src="https://gist.github.com/sthewissen/98d7dad7ef73ef5a4380.js"></script>

