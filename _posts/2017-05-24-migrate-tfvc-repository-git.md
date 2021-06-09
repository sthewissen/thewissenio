---
layout: post
title: Migrate your TFVC repository to Git
date: '2017-05-24 18:07:22 +0200'
categories:
- Code
tags:
- azure devops
image: '/images/headers/lego-1.jpg'
---

When using Visual Studio Team Services (VSTS) you have the choice to create a repository using Team Foundation Version Control (TFVC) or Git. Up until recently there wasn't really a simple option to migrate from one to the other. Our company is slowly transitioning to Git and now there's a new migration option! 

### Let's set some ground rules

In our case we had approximately 140 repositories that were TFVC based since they were migrated to VSTS from a TFS on-premise installation years ago. The new migration option is built into VSTS and is called **Import repository**. For the context of this post both importing and migrating will be used but they essentially mean the same. Since migration is a disruptive process there are a few things you should probably know about.

*   You can only migrate up to 180 days of history.
*   The imported repository and its history (if imported) cannot exceed 1GB in size. This means that if you have a pretty large repository this is not the way to go for you.
*   It only migrates the contents of the root or a branch. This means that if you want to migrate from a certain path in your TFVC structure it will only migrate the content. It will not migrate any branches within the given path unless you explicitly target them as the migration path.

### Moving to Git

With those ground rules layed out we can start migrating our repos. Navigate to your TFVC repository and click on its name in the top left corner.

![Select your TFVC repository](/images/posts/repos.png?style=halfsize)

Pick **Import repository** from the menu and you should see the popup below. Here we can select what the type of our **Source** repository is. More then likely you will pick ***TFVC*** here because going from Git to TFVC isn't something a lot of people will be doing. It is possible though! Next up we type the **Path** to the folder or branch we want to migrate and check the box if we want to migrate our history. This slider can range between 1 day and 180 days. It's up to you! Lastly we give our new Git repository a nice name and press **Import** to start the process.

![Time to migrate to Git!](/images/posts/migrate.png?style=halfsize)

While VSTS starts processing your request you can either go grab a well-earned cup of coffee or just wait out the migration. It shouldn't take too long if your repository isn't that large. Your code gets put inside a **master** branch in the new Git-based repository and you can carry on coding using Git!

![Migrating your project now!](/images/posts/busymigrating.png?style=halfsize)

### Cleanup and a history lesson

So what to do with the TFVC repo? You won't be coding in it anymore that's for sure. You can leave it be and consider it to be an excellent piece of history. Unfortunately you cannot delete it at the point of this writing. That's a feature reserved exclusively for Git repos. If you leave it then make sure you give some additional instructions to your developers to not use it anymore. You could also solve this problem by altering the security of the repository to make it visible to VSTS Administrators only.

Since we're talking about your old TFVC history I'd like to mention that migrating your history is strongly discouraged. You're moving to a fundamentally different version control system and history works differently in Git. The best option is to leave the TFVC repository be and carry on creating a brand new history in Git. The TFVC history is maintained so if you need to look back into it its there for you.

### Conclusion

This feature works great when you have a relatively straight forward and simple repository. Cleaning it up before migrating also helps a lot. Keep in mind that you're moving from a centralized version control system to a distributed one which comes with additional challenges. Microsoft has some excellent whitepapers on this process and what you should consider when migrating. Check them out! [Centralized version control to Git](https://www.visualstudio.com/learn/centralized-to-git/) and [TFVC to Git](https://www.visualstudio.com/learn/migrate-from-tfvc-to-git/).