---
layout: post
title: Adding some Swagger to your Web APIs
date: '2017-03-01 16:22:00 +0100'
categories:
- Code
tags:
- ".net"
---



In a Web API project I recently started working on I found that testing it using a tool like Postman works pretty well, but having to type out all your test requests can become quite tedious. That's about the time Swagger and Swashbuckle came along to play!



Swagger is a JSON oriented description language for your REST web services. This specification has been standardised in the OpenAPI Specification (OAS). There are loads of tools being built upon the Swagger framework that use this description language and one of the easiest to start off with is Swagger-UI. This adds an endpoint to your application listing all the available operations in your API project and lets you test them directly from the same page. No more manual labor typing all your requests into a tool like Postman needed! Swashbuckle is ASP.NET version of this tooling and features a built in Swagger generator for ASP.NET Web API projects along with middleware to expose the generated Swagger as JSON endpoints and middleware to expose a Swagger-UI that's powered by those endpoints.



### So how do I get this?




Quite simple actually, follow these steps :)



1.  Install the standard Nuget package (currently pre-release) into your ASP.NET Core application.


`Install-Package Swashbuckle.AspNetCore -Pre`


    
2.  In the *ConfigureServices* method of *Startup.cs*, register the Swagger generator, defining one or more Swagger documents.


services.AddMvc();
    
        services.AddSwaggerGen(c =>
    {
        c.SwaggerDoc("v1", new Info { Title = "Unicorns API", Version = "v1" });
    });


    
3.  Ensure your API actions and non-route parameters are decorated with explicit "Http" and "From" bindings. *NOTE: If you omit the explicit parameter bindings, the generator will describe them as "query" params by default.*


[HttpPost]
    public void Create([FromBody]Product product)
    ...
    
        [HttpGet]
    public IEnumerable Search([FromQuery]string keywords)
    ...


    
4.  In the *Configure* method, insert middleware to expose the generated Swagger as JSON endpoint(s)


app.UseSwagger();


    
5.  Optionally insert the swagger-ui middleware if you want to expose interactive documentation, specifying the Swagger JSON endpoint(s) to power it from.


app.UseSwaggerUI(c =>
    {
        c.SwaggerEndpoint("/swagger/v1/swagger.json", "Unicorns API v1");
    });


    


Now you can restart your application and check out the auto-generated, interactive docs at "/swagger" and it should look something like the following!



[![swagger](/images/posts/swagger-1024x599.png)](/images/posts/swagger.png)

