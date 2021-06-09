---
layout: post
title: Entity Framework performance tips
date: '2015-03-10 21:41:32 +0100'
categories:
- Code
tags:
- ".net"
---



To honor the name of this blog I will also be writing posts about software development. The software developer that hasn't turned to Google for some advice once in a while hasn't been born yet. As a software developer you cannot know all the ins and outs of your trade. It might sound harsh but some people are probably smarter than you. When I'm looking for articles on code I find it comforting when they're in English. Nothing is worse than looking for a solution or advice and finding out something that might solve your problem is written in a language you don't understand. Enough about me talking English, let's go see some code.



As a developer I regularly use Entity Framework as my ORM of choice. Being brought up on Microsoft technologies through the company I work for it seems only logical to use it. Although I know of other frameworks I just haven't had the time to look into them and EF meets my needs, so why bother to switch? And even though EF is my ORM of choice, I am always looking to improve upon my own code. In this post I'll be talking about how I try to improve the perfomance of my EF queries along with some other patterns I regularly use. But first, a disclaimer:

**Disclaimer:** The opinions and pieces of code in this article are my own and do not represent the company I work for in any way.


Now that we have that behind us, let's carry on!



### 1. Go easy on the abstraction patterns




An example of this is the **Repository** pattern. A lot of articles online will advise you to use the pattern to serve as a nice abstraction layer over your ORM. Though I can see the value of the pattern, it isn't always as useful as advocated. One reason for that is that Entity Framework already implements a Repository pattern in itself. In my opinion your business requirements should be leading your architecture. Do you actually need to be able to switch out the data provider? Is that something that **will** happen during the course of the project? If you don't then why would you go through all the effort to create an abstraction on top of it? The only thing you're doing is writing a wrapper around a powerful framework, thus making those powerful features harder to use and creating an unnecessary overhead and additional code.



Another reason people use the Repository pattern is unit-testing. It makes it easier to mock out your data provider. However, that reason alone is not something that warrants using the Repository pattern. There are numerous ways in EF to create an in-memory mocked `DbContext` class which you could use to write your unit tests. You shouldn't be the one creating the business requirements to fit your own (preferred) architecture. Speculative architecture is what they call it I believe and it's horrible. However, if you have an actual business need to switch out the data provider and you know that in advance, you should adjust your architecture accordingly.



### 2. Add paging to your views




No one loves to scroll through a huge list of items. Your database crawls to a halt when you retrieve huge amounts of records from it and will rightfully hate you for it. Try to limit the amount of records you retrieve to a minimum whenever possible. A component like [PagedList](https://www.nuget.org/packages/PagedList.Mvc) helps you out in both usability and performance.



### 3. Avoid lazy loading whenever possible




Lazy loading is a great feature in theory. All it takes is the `virtual` keyword and you can lazy load your objects, meaning they won't be loaded until you need them. The problem is that lazy loading also makes for a lazy programmer. You easily forget about it even being there, because all the data you query will eventually find its way into your views. However, it causes more roundtrips to the database while in some situations you would be better off using eager loading. When you know in advance that you'll need some of the data from an object's child collections, you can retrieve everything you need in a single statement using `.Include()`:



// Load all blogs and related posts.
    var blogs = context.Blogs 
                .Include(b => b.Posts) 
                .ToList();



You can also load multiple levels using `.Select()`, but this is limited because you cannot filter the amount of records returned from the Select:



// Load all blogs, all related posts, and all related comments.
    var blogs2 = context.Blogs 
                 .Include(b => b.Posts.Select(p => p.Comments)) 
                 .ToList();



If you do want to apply additional filtering you could use the deferred execution features to your advantage to specify your query further so it returns exactly what you want to load. You can disable lazy loading for the entire application from within the constructor of your context class or you can disable it for a specific property by not declaring it as `virtual`.



// Disable lazy loading application-wide.
    public BloggingContext() 
    { 
        this.Configuration.LazyLoadingEnabled = false; 
    }
    



### 4. Only select what you need




To elaborate further on the paragraph above, you can also use `.Select()` to select a specific list of columns. When you only need 2 columns of an object that consists of 20 columns you're wasting performance selecting the other 18 columns. Using `.Select()` you can specify which columns to load and EF will convert this into a nice query. You can even use an anonymous class as the return value of your query and feed that to your ViewModel to ensure that you retrieve your data in a performance friendly way.



var projection = from b in context.Blogs
                     where b.Tag == "development"
                     select new { 
                         b.Title, b.Body
                     };



###  5. Add indexes




A relational database performs better when you have added some meaningful indexes. Everyone probably knows that. Since EF 6.1, indexes can be defined using code-first by adding the `Index` attribute to properties you want to create an index for. You can even specify multiple column indexes using this attribute.



public class Post 
    { 
        public int Id { get; set; } 
        public string Title { get; set; } 
        // A single column index, using default naming conventions.
        [Index]
        public int AuthorId { get; set; }
        public string Content { get; set; } 
        // When creating a multi column index, you need to specify an order.
        [Index("IX_BlogIdAndRating", 2)] 
        public int Rating { get; set; } 
        [Index("IX_BlogIdAndRating", 1)] 
        public int BlogId { get; set; } 
    }



###  6. Don't track changes when all you're doing is reading data




You probably have a lot of pages in your application that will only show your data in a read-only fashion. Nothing too fancy, no adding, editing or deleting data needed. However, internally EF will always maintain the state changes you make to your objects unless you tell it not to. You can see that for a page where no data is being edited tracking these changes is useless. You can disable it by writing your queries just a little bit differently:



context.Posts.AsNoTracking().ToList();



Notice the `AsNoTracking()` statement. This method ensures that your object state is not being tracked.



### Conclusion




Entity Framework is a nice framework, but when you're using it out of the box it will not automatically give you the best performance possible. There are loads of little mistakes you can make that can grind your application to a halt. The few tips I've mentioned above are just some of the things that can speed up your performance when using Entity Framework. There are undoubtedly loads more things you can but I have found that taking care of the above is a good starting point.

