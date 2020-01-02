<?php get_header(); ?>

	<section class="section section__single">
        <div class="wrap">
	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('single-post__wrapper'); ?>>
		
			<div class="row center-lg">
				<div class="single-post__tags">
					<?php the_tags( '<ul class="single-post__tags-list"><li>', '</li><li>', '</li></ul>' ); ?>
				</div>		
			</div>	

			<h1 class="single-post__title">
				<?php the_title(); ?>
			</h1>

			<div class="single-post__meta">
				<div class="single-post__meta__author"><?php the_author_posts_link(); ?></div>
				<div class="single-post__meta__data">
					<?php _e( 'Posted on ', 'thewissenio' ); ?>
					<span class="single-post__meta__date"><?php the_date(); ?> <?php the_time(); ?></span>
					<?php _e( ' in ', 'thewissenio' ); ?>
					<span class="single-post__meta__category"><?php the_category(', '); ?></span>
				</div>
				
			</div>

            <div class="row center-lg single-post__image">
                <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
					<?php the_post_thumbnail('single-page'); // Fullsize image for the single post ?>
					<?php 
						$args = array(
							'class' => 'single-post__author'
						   );
						echo get_avatar( get_the_author_meta( 'ID' ), 150, null, null, $args); 
					?>
                <?php endif; ?>
            </div>

			<div class="row center-lg">
				<div class="single-post__content">
					<?php the_content(); // Dynamic Content ?>
				</div>
			</div>

			<?php edit_post_link(); // Always handy to have Edit Post Links available ?>
			
		</article>
	<?php endwhile; ?>

	<?php else: ?>
		
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'thewissenio' ); ?></h1>

		</article>

	<?php endif; ?>

        </div>
	
	</section>

<?php get_footer(); ?>