<?php get_header(); ?>

    <header class="header">
        <div class="header__content">
            <div class="wrap">
                <div class="row">
                    <div class="col-lg-10">
                        <h3 class="header__subtitle">Hi! I'm Steven Thewissen 👋</h3>
                        <h1 class="header__title">
                            <span id="typewriter"></span>
                            <span class="header__title__static"><br/>from the Netherlands</span>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 header__flex">
                        <div class="header__avatar"></div>
                        <div class="header__intro">
                            <span class="header__intro__pronounciation" onclick="playAudio('<?php echo get_template_directory_uri(); ?>/static/sounds/sthewissen.mp3')">
                                <i id="play" class="fas fa-volume-up"></i> /ˈSTIːVƏN TEIːWISːSƐN/
                            </span>
                            A software developer from the Netherlands focusing on Xamarin development, crafting fancy UIs, 
                            tinkering in Azure DevOps and developing REST APIs. I started working with Xamarin in 2014 and have been in 
                            love with it ever since.
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="header__intro__secondpart">
                            When I'm not coding you can find me writing blogs, tweeting, playing soccer, or just having 
                            some fun and the occasional drink with my friends. If you bring cookies, chocolate and/or a nice beer we can quickly
                            become best friends. 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section section--blogs">
        <div class="section__header">
            <div class="wrap">
                <div class="row center-lg">
                    <div class="col-lg-7">
                        <h2 class="section__title">Latest blogs</h2>
                        <p class="section__description">I occasionally write about things that interest me or problems I've encountered during my development adventures. These are the chronicles of those experiences.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-block__grid">
            <div class="wrap">
                <div class="row">
                    
                <?php get_template_part('loop'); ?>

                </div>
            </div>
        </div>
    </section>

    <section class="section section--projects">
        <div class="section__header">
            <div class="wrap">
                <div class="row center-lg">
                    <div class="col-lg-6">
                        <h2 class="section__title">Projects</h2>
                        <p class="section__description">I love blogging, but I probably love coding even more. That's why I also work on open source projects and even wrote a book about Xamarin!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src='<?php echo get_template_directory_uri(); ?>/js/lib/typewriter.js'></script>


<?php get_footer(); ?>
