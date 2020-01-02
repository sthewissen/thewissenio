<?php if (!empty($related_posts)) { ?>

    <section class="section section--blogs">
        <div class="section__header">
            <div class="wrap">
                <div class="row center-lg">
                    <div class="col-lg-7">
                        <h2 class="section__title"><?php _e( 'Related articles', 'thewissenio' ); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-block__grid">
            <div class="wrap">
                <div class="row">                    
                    <?php
                    foreach ($related_posts as $post) {
                        setup_postdata($post);
                    ?>

                    <?php get_template_part('loop-post'); ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php
}