---
layout: post
title: Implementing MSAL authentication in Xamarin.Forms
date: '2020-02-04 19:34:26 +0100'
categories: Code
tags: xamarin xamarin.forms
image: '/images/headers/lock.jpg'
---
Authenticating users in our app is a common challenge that mobile developers need to tackle. Leveraging existing authentication systems like those of social networks or big companies like Microsoft's MSAL saves a lot of development time. But how do we get started?

Due to the length of this blog post, I figured it would be nice to have a quick index allowing you to skip to all of the relevant topics:

1.  [What is the Microsoft Authentication Library (MSAL)](#what)
2.  [A quick note about authentication](#note)
3.  [How to get started](#getstarted)
4.  [Let's do some Xamarin next!](#xamarin)
5.  [Handling iOS specifics](#ios)
6.  [Handling Android specifics](#android)
7.  [Putting it all together](#wrapup)
8.  [In closing](#conclusion)

### <a name="what"/>What is the Microsoft Authentication Library (MSAL)?

If you've ever logged into a Microsoft-related app or website you have probably seen MSAL in action. Most of you will recognize the dialog below where you log in using a personal or your work/school account. Some of you might've even gotten frustrated by this exact screen on occasion. Under the hood, both of these sign-in flows are using MSAL.

![MSAL authentication in the wild!](/images/posts/image-38.png)

If this topic is something you've already researched you may have also come across the term ADAL. This is the predecessor to MSAL. However, MSAL is the recommended authentication library to use with the Microsoft identity platform. The [library itself](https://docs.microsoft.com/en-us/azure/active-directory/develop/msal-overview) is available on both the Android and iOS platforms. This makes it extremely suitable for what we're trying to achieve in this post.

Using MSAL, we can easily acquire tokens for users signing-in to our application with Azure AD (work and school accounts or B2C) or personal Microsoft accounts. Delegating the authentication flow to a third party saves you the time of rolling your own and maintaining it throughout the lifespan of your app.

![When our tokens are OK](/images/posts/source.gif)

### <a name="note"/>A quick note about authentication

When authenticating a mobile app using an external service I find the following flow to be the most user-friendly and it is pretty commonplace at this point. This is also what we'll be implementing in this post. A simplified version of it looks like this:

*   The authentication flow is opened in the user's default browser from the app. This allows the user to easily sign in if his browser session is already logged in. It's also a lot more secure than using e.g. an embedded `WebView` inside your app.
*   Once authentication is successful, a redirect is done, which re-opens the app. This redirect provides the authentication state to it.
*   The app can subsequently store the authentication state and any additional state to refresh the authentication in a secure storage location.

A lot of these steps are handled from within MSAL, abstracting it away for you. Some additional configuration steps are still needed though, which is what we'll look at next.

### <a name="getstarted"/>How to get started

Each application using MSAL needs to register itself with Microsoft to be able to use it. We can perform this step on the [Azure Portal](https://portal.azure.com) by clicking the hamburger menu and clicking _Azure Active Directory_. After clicking on _App Registrations_ we can click _New Registration_ to get started.

![Creating a new app registration.](/images/posts/image-39.png)

First, we need to provide a _Name_ for our application. Then we need to select the type of accounts we want to grant access to our app. We can limit this to specific Azure Active directory tenants if needed. In the screenshot above I set the app to be publicly accessible using Azure AD accounts **and** personal Microsoft accounts. Click the _Register_ button and Azure will create the application registration.

![Finding the application ID](/images/posts/image-40.png)
*We will need the Application (client) ID later.*

It's important to take note of the generated **Application (client) ID** because we need it later. You can find it in the _Overview_ tab of the application registration we just created. Lastly, we need to make sure that our redirects are set up correctly. Go to the _Authentication_ tab and click the **Add platform** button to add both an iOS and an Android app. For these, we need to fill in our app identifier and in the case of Android, we also need to provide a **signature hash**. Luckily, the command to generate one is right there! Run that command in your Android SDK Command Prompt and you should be good to go! Keep that signature hash handy, because we're going to need it. Also, don't forget to hit **Save**!

![Creating two new redirect URI entries for iOS and Android.](/images/posts/image-49.png)
*Creating two new redirect URI entries for iOS and Android.*

### <a name="xamarin"/>Let's do some Xamarin next!

With all of those preparations out of the way, we can start integrating all of this in our Xamarin app. First, we need to get MSAL installed. Luckily, it's available as a NuGet package so let's search for `Microsoft.Identity.Client` and add it to both our shared project and our platform-specific projects.

Next, we create a class that will wrap around the MSAL NuGet package and provides us with a few simple methods to sign in to the application and to sign out. All of the interaction with the Microsoft identity service goes through the PCA (Public Client Application) which is set up in the constructor of this class. It is initialized with the **Application (client) ID** that we generated earlier, along with a redirect URI and an authority. The redirect URI differs per platform, so I wrote a helper property that takes care of constructing the correct one.

<script src="https://gist.github.com/sthewissen/e37c107f702f25b436f3e7396c1b1d04.js"></script>  

This initialization method takes an additional parameter specifically for iOS, namely the Keychain security group. We will make the actual Keychain group later in this blogpost, so provide it with the app identifier of our app for now.

#### Adding the sign-in method

As a user, you don't want to have to sign in every time you use the app. Luckily, MSAL already caches your authorization and can log you in silently if it's still valid. Our implementation of the sign-in method shows how we can leverage this behavior. If our authorization is not cached anymore, the user is presented with a sign-in dialog to complete the process.

<script src="https://gist.github.com/sthewissen/d78b6682ae7423051aa05d1ced9de73f.js"></script> 

When properly authenticated we receive an **access token** that we can subsequently use to query other APIs that are secured by MSAL. We store this token in secure storage using [Xamarin Essentials](https://github.com/xamarin/Essentials).

#### Adding the sign out method

Signing out is pretty straight forward. We go through all the available accounts that MSAL has locally cached for us and sign them out. We also clear the access token that we stored in secure storage when we signed in.

<script src="https://gist.github.com/sthewissen/adbf692296eb5747ba041f5ad6ecd8cb.js"></script>

Each individual platform that we target with our app has its own additional configuration that we need to do as well. Let's take a look at each of these next.

### <a name="ios"/>Handling iOS specifics

When the authentication using MSAL is successful our app should receive a redirect from the sign-in page we opened externally. This ensures that our app is opened again once the authentication flow is completed. To do this on iOS we need to override the `OpenUrl` method in our `AppDelegate` class. We can then simply call into MSAL to trigger it to continue the authentication flow. This method returns `true` to indicate that we've handled the callback.

<script src="https://gist.github.com/sthewissen/ef060dbb4b4ea67d45e586ed55899719.js"></script>

Next, open up your `Entitlements.plist` file and check _Enable Keychain_. This will add an entry for our app to Keychain, which is where iOS securely stores our credentials. To read more about MSAL and Keychain you can read [these Microsoft docs](https://docs.microsoft.com/en-us/azure/active-directory/develop/msal-net-xamarin-ios-considerations).

![Enabling Keychain access for our app.](/images/posts/image-45.png)
*Enabling Keychain access for our app.*

To allow our app to use the Keychain we also need to set our _Custom Entitlements_ setting to point to our `Entitlements.plist` file. To find this setting go to the _Options_ of your iOS project and click the _iOS Bundle Signing_ tab.

![Set custom entitlements.](/images/posts/image-42.png)
*Setup your custom entitlements.*

Lastly, we need to configure our iOS app to respond to the callback URL we defined in our shared code. We do this in our `Info.plist` file by defining a URL type. Add one through the UI or just directly edit the file itself in your favorite text editor. Use the following values for it:

*   **Identifier:** Your current app bundle identifier
*   **URL scheme:** `msauth.{YOUR APP IDENTIFIER}://auth`
*   **Role:** Editor

<script src="https://gist.github.com/sthewissen/36bfdef717b7c275c0d9780a7657aa3f.js"></script>

### <a name="android"/>Handling Android specifics

When it comes to Android we need to perform similar steps as we did with iOS, such as making the app respond to redirects and handling them correctly. Start by overriding `OnActivityResult` in your `MainActivity`. Add the following code to it, which will ensure that control goes back to our app once the MSAL authentication flow is complete.

<script src="https://gist.github.com/sthewissen/614859b5139c2c8c9c2988091239aff4.js"></script>

Similar to iOS we also need to inform our Android app that it has to open again when receiving a specific callback URL. This is done through the `AndroidManifest.xml` file by providing it with an `activity` and an `intent-filter`. Ensure you add the following code inside the `application` tag:

<script src="https://gist.github.com/sthewissen/f2ebe9934ab19624ec6ab8160b173c69.js"></script>
  
As you can see this is where the **Signature hash** has to be provided once more. Append it to the app identifier to indicate that this is the callback URL the app has to react to. That wraps up all the configuration we need! [Microsoft's documentation](https://docs.microsoft.com/en-us/azure/active-directory/develop/tutorial-v2-android) suggests using the non-URL encoded version of the signature hash. However, I could not get that to work for my app personally. Using the URL encoded version did work for me.

### <a name="wrapup"/>Putting it all together

With all of our plumbing code in place, we can now start authenticating users in our app. I've made a basic sample app with a button that calls into our authorization service and starts the sign-in flow. Once signed in, it queries the Microsoft Graph API to retrieve the user's name and displays it.

<script src="https://gist.github.com/sthewissen/874be19d9e636549ade3de496d7a85d5.js"></script>  

### <a name="conclusion"/>In closing...

I've put the [sample app on GitHub](https://github.com/sthewissen/MSALSample). It should contain almost everything I've talked about in this blog post except for an actual **Application client ID** and a **Signature hash** from Azure Active Directory. You will need to generate these yourself and add them to all the locations we've used it in this post to see it all in action. Hopefully, this blog post has given you some insight into how to implement MSAL into your mobile app. If you have any questions, feel free to reach out to me [on Twitter](https://www.twitter.com/devnl) or through the sample GitHub repo.

![The end result is a MS login box opened in the browser,](/images/posts/image-44.png?style=halfsize)