---
layout: post
title: Generating your own custom icon font made easy
date: '2020-03-26 21:40:52 +0100'
categories: Short
tags: ui tools
image: '/images/headers/letters.jpg'
---
Using an icon font in your app [has been all the rage](https://www.thewissen.io/using-custom-fonts-in-xamarin-forms/) for a while now, but what if the existing ones aren't to your liking? It's pretty easy to make your own if you have vector art available for them. Let's take a peek!

### Getting some icons
The first step is obviously to be in the possession of icons that you want to turn into a font. If you have some experience in vector-based drawing software like Illustrator you could try your hand at designing your own icons. Alternatively, if you have a designer on speed-dial you might already have some resources to start with. Or maybe you already found a set of SVG files on the internet that you want to turn into a custom font (you may want to check on their license though).

I will use the icon set below as a sample throughout this post as it is very relevant to the situation the world is in right now. You can get your own copy of this free icon set [here](https://www.sketchappsources.com/free-source/4331-stop-virus-outline-icons-sketch-freebie-resource.html).

![Find or create your icons.](/images/posts/stop-virus-outline-icons-iconfinder-nandiny.png)
*Step 1: Find or create your icons.*

### Select the icons you need
Various tools exist to generate a font for you based on SVG files. I personally enjoy using [IcoMoon](https://icomoon.io/app/) a lot so it's the one I will be using in this post. It's free too! The first step is to import our icons, which is done through the big Import icons button at the top left of the screen. You should end up with an **Untitled Set** containing all of your icons.

![Upload SVG files to IcoMoon.](/images/posts/image-52.png)
*Step 2: Upload SVG files to IcoMoon.*

Your icons might not have a yellow border around them when you first import them. Using the selection option from the toolbox at the top you can select which icons are included in your font. This toolbox also contains tools to remove, re-order or edit icons. In my sample, I simply selected all of the icons.

### Name your icon font
By default, your set of icons is called **Untitled Set**. Since that is not the fanciest font name you can come up with we have the option to change that. By clicking the hamburger menu next to our icon set and going to **Properties** we can specify some metadata for our font.

![Name your font!](/images/posts/image-53.png)
*Step 3: Name your font!*

### Generating an icon font
Our next step is to generate the actual font files which are only a few button clicks away! By clicking the **Generate Font** tab on the bottom we are presented with a view of all of our icons and which Unicode code they will occupy in the font. This screen also allows you to name your icons.
We can click **Preferences** here to name our font as well. This will be the PostScript name, which you need when you're going to be using this font in a Xamarin app e.g. Click **Download** and your font is good to go!

### Storing your configuration
If you want to come back to this font at a later stage to add new icons you will need to store its definition somewhere. Or perhaps if your team consists of multiple people that need to access it you want to put this definition into source control. Pop open the hamburger menu next to the icon set again and click on **Download JSON** which will create a JSON definition of your icons and their names and codes. Easy!

![Download and store your icon font definition.](/images/posts/image-54.png)
*Step 4: Download and store your icon font definition.*

### Bonus: Turning your icon font into C# code!
So now you have your font, but you want to use it in C#. Luckily, Andrei Nițescu has you covered! He has built [this awesome tool](https://andreinitescu.github.io/IconFont2Code/) to turn your icon font into a strongly typed C# class! All you have to do is upload the font file you just downloaded from IcoMoon and it should generate a simple class for you.

However, the IcoMoon download also contains a CSS file, which allows you to automatically generate correct constant names for your icons based on the names you specified earlier. Truly an awesome tool that you should check out!

![](/images/posts/image-55.png)

### Conclusion
Creating a custom icon font isn't hard. Once you complete the steps a few times you should be able to (re)generate one in a matter of minutes. Unfortunately, not all SVG files are suited for this process. Some icons might have parts that seem transparent but are actually filled with white. This means that once converted to a font that icon becomes a single-colored blob. If that happens there's not much you can do except change the original SVG file or find a different icon.