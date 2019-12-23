<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>" class="col-lg-4 col-sm-12">
		<div class="blog-block__item">
			<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
				<header class="blog-block__header" style="background-image: url('<?php the_post_thumbnail_url('front-page'); // Declare pixel size you need inside the array ?>')">
					<span class="blog-block__category"><?php the_category(); ?></span>
				</header>
			<?php endif; ?>
			<article class="blog-block__content">
				<span class="blog-block__date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>

				<h3 class="blog-block__title"><?php the_title(); ?></h3>
				<p class="blog-block__intro">
					<?php thewio_excerpt('thewio_index'); // Build your custom callback length in functions.php ?>
				</p>
			</article>
			<footer class="blog-block__links">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="blog-block__link"><?php _e( 'Read more...', 'thewissenio' ); ?></a>
			</footer>
		</div>
	</div>

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'thewissenio' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>