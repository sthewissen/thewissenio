<?php 

	$i = 1;

	if (have_posts()): while (have_posts()) : the_post(); ?>

	<?php 

	// if ($i != 1 && $i != 2) 
	// { 
	// 	get_template_part('loop-post');
	// }
	// else
	// {
	 	get_template_part('loop-post-wide');
	// }
	
	$i = $i + 1;

	?>

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'thewissenio' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>