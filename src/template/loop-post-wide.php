<div id="post-<?php the_ID(); ?>" class="blog-block__post col-lg-5 col-sm-12">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="blog-block__item">
        <?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
            <header class="blog-block__header__wide" style="background-image: url('<?php the_post_thumbnail_url('front-page-wide-md'); // Declare pixel size you need inside the array ?>')"></header>
        <?php endif; ?>
        <article class="blog-block__content">
            <span class="blog-block__category"><?php 
            $cats = array();
            foreach (get_the_category($post_id) as $c) {
            $cat = get_category($c);
            array_push($cats, $cat->name);
            }
            
            if (sizeOf($cats) > 0) {
            $post_categories = implode(', ', $cats);
            } else {
            $post_categories = 'Not Assigned';
            }
            
            echo $post_categories;
            ?></span>
            <h3 class="blog-block__title"><?php the_title(); ?></h3>
            <span class="blog-block__date">
                <?php the_date(); ?> <?php the_time(); ?>
            </span>
            <p class="blog-block__intro">
                <?php thewio_excerpt('thewio_index_long'); ?>
            </p>
        </article>
    </a>
</div>