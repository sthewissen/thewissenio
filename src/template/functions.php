<?php

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail

    add_image_size('single-page', 850, 310, true); 
    add_image_size('front-page', 375, 190, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    // load_theme_textdomain('thewissenio', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Thewissen.io navigation
function thewissenio_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

function thewissenio_related_posts($args = array()) {
    global $post;

    // default args
    $args = wp_parse_args($args, array(
        'post_id' => !empty($post) ? $post->ID : '',
        'taxonomy' => 'post_tag',
        'limit' => 3,
        'post_type' => !empty($post) ? $post->post_type : 'post',
        'orderby' => 'date',
        'order' => 'DESC'
    ));

    // // check taxonomy
    // if (!taxonomy_exists($args['taxonomy'])) {
    //     return;
    // }

    // // post taxonomies
    // $taxonomies = wp_get_post_terms($args['post_id'], $args['taxonomy'], array('fields' => 'ids'));

    // if (empty($taxonomies)) {
    //     return;
    // }

    // // query
    // $related_posts = get_posts(array(
    //     'post__not_in' => (array) $args['post_id'],
    //     'post_type' => $args['post_type'],
    //     'tax_query' => array(
    //         array(
    //             'taxonomy' => $args['taxonomy'],
    //             'field' => 'term_id',
    //             'terms' => $taxonomies
    //         ),
    //     ),
    //     'posts_per_page' => $args['limit'],
    //     'orderby' => $args['orderby'],
    //     'order' => $args['order']
    // ));

    $related_posts = exe_get_related_posts_by_common_terms($args['post_id'], $args['limit']);

    include(locate_template('related-posts.php', false, false));

    wp_reset_postdata();
}

function exe_get_related_posts_by_common_terms( $post_id, $number_posts = 0, $taxonomy = 'post_tag', $post_type = 'post' ) {
    global $wpdb;

    $post_id = (int) $post_id;
    $number_posts = (int) $number_posts;

    $limit = $number_posts > 0 ? ' LIMIT ' . $number_posts : '';

    $related_posts_records = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT tr.object_id, count( tr.term_taxonomy_id ) AS common_tax_count
             FROM {$wpdb->term_relationships} AS tr
             INNER JOIN {$wpdb->term_relationships} AS tr2 ON tr.term_taxonomy_id = tr2.term_taxonomy_id
             INNER JOIN {$wpdb->term_taxonomy} as tt ON tt.term_taxonomy_id = tr2.term_taxonomy_id
             INNER JOIN {$wpdb->posts} as p ON p.ID = tr.object_id
             WHERE
                tr2.object_id = %d
                AND tt.taxonomy = %s
                AND p.post_type = %s
                AND p.post_status = 'publish'
             GROUP BY tr.object_id
             HAVING tr.object_id != %d
             ORDER BY common_tax_count DESC" . $limit,
            $post_id, $taxonomy, $post_type, $post_id
        )
    );

    if ( count( $related_posts_records ) === 0 )
        return false;

    $related_posts = array();

    foreach( $related_posts_records as $record )
        $related_posts[] = (int)$record->object_id;

    return $related_posts;
}


// Load Thewissen.io scripts (header.php)
function thewissenio_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('thewissenioscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('thewissenioscripts'); // Enqueue it!
    }
}

// Load Thewissen.io conditional scripts
function thewissenio_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load Thewissen.io styles
function thewissenio_styles()
{
    // wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    // wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('thewissenio', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('thewissenio'); // Enqueue it!
}

// Register Thewissen.io Navigation
function register_thewio_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'thewissenio'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'thewissenio'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'thewissenio') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'thewissenio'),
        'description' => __('Description for this widget-area...', 'thewissenio'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'thewissenio'),
        'description' => __('Description for this widget-area...', 'thewissenio'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function thewio_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'before_page_number' => '<span>',
        'after_page_number'  => '</span>',
        'prev_text' => '<span>«</span>',
        'next_text' => '<span>»</span>'
    ));
}

// Custom Excerpts
function thewio_index($length) // Create 20 Word Callback for Index page Excerpts, call using thewio_excerpt('thewio_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using thewio_excerpt('thewio_custom_post');
function thewio_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function thewio_excerpt($length_callback = '', $more_callback = '')
{
    global $post;

    // if (function_exists($length_callback)) {
    //     add_filter('excerpt_length', $length_callback);
    // }

    // if (function_exists($more_callback)) {
    //     add_filter('excerpt_more', $more_callback);
    // }

    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    // $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function thewio_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'thewissenio') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function thewio_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function thewisseniogravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function thewisseniocomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'thewissenio_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'thewissenio_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'thewissenio_styles'); // Add Theme Stylesheet
add_action('init', 'register_thewio_menu'); // Add Thewissen.io Menu
add_action('init', 'create_post_type_thewio'); // Add our Thewissen.io Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'thewio_pagination'); // Add our thewio Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'thewisseniogravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
// add_filter('excerpt_more', 'thewio_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'thewio_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('thewio_shortcode_demo', 'thewio_shortcode_demo'); // You can place [thewio_shortcode_demo] in Pages, Posts now.
add_shortcode('thewio_shortcode_demo_2', 'thewio_shortcode_demo_2'); // Place [thewio_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [thewio_shortcode_demo] [thewio_shortcode_demo_2] Here's the page title! [/thewio_shortcode_demo_2] [/thewio_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called thewio-Blank
function create_post_type_thewio()
{
    register_taxonomy_for_object_type('category', 'thewio-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'thewio-blank');
    register_post_type('thewio-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Thewissen.io Custom Post', 'thewissenio'), // Rename these to suit
            'singular_name' => __('Thewissen.io Custom Post', 'thewissenio'),
            'add_new' => __('Add New', 'thewissenio'),
            'add_new_item' => __('Add New Thewissen.io Custom Post', 'thewissenio'),
            'edit' => __('Edit', 'thewissenio'),
            'edit_item' => __('Edit Thewissen.io Custom Post', 'thewissenio'),
            'new_item' => __('New Thewissen.io Custom Post', 'thewissenio'),
            'view' => __('View Thewissen.io Custom Post', 'thewissenio'),
            'view_item' => __('View Thewissen.io Custom Post', 'thewissenio'),
            'search_items' => __('Search Thewissen.io Custom Post', 'thewissenio'),
            'not_found' => __('No Thewissen.io Custom Posts found', 'thewissenio'),
            'not_found_in_trash' => __('No Thewissen.io Custom Posts found in Trash', 'thewissenio')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom Thewissen.io post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function thewio_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function thewio_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}

?>
