<?php get_header(); ?>

<section class="section section__overview">
	<div class="wrap">
		<div class="row center-lg">
			<?php include('logo.php'); ?>
		</div>
		<div class="row center-lg">
			<h1 class="overview__title">
				<?php _e( 'The Archives', 'thewissenio' ); echo single_tag_title('', false); ?>
			</h1>
		</div>
        <div class="blog-block__grid">
            <div class="wrap">
                <div class="row">  
					<?php 
						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
						query_posts( array( 'posts_per_page' => 6, 'post_status' => 'publish', 'paged' => $paged ) ); 
					?>
                    <?php get_template_part('loop'); ?>
                </div>            
				<div class="row center-lg">   
					<?php get_template_part('pagination'); ?>
				</div>
            </div>
        </div>
	</div>
</section>

<?php get_footer(); ?>