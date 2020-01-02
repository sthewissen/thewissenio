<?php get_header(); ?>

<section class="section section__overview">
	<div class="wrap">
		<div class="row center-lg">
			<h1 class="overview__title">
				<?php _e( 'Archive for ', 'thewissenio' ); echo single_cat_title('', false); ?>
			</h1>
		</div>
        <div class="blog-block__grid">
            <div class="wrap">
                <div class="row">                    
                    <?php get_template_part('loop'); ?>
                </div>               
				<?php get_template_part('pagination'); ?>
            </div>
        </div>
	</div>
</section>

<?php get_footer(); ?>