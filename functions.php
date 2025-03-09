<?php
/**
	Custom functions for 3cb24 theme

	@package tcb24
 */

/**
 * Theme support elements.
 */
function tcb24_theme_setup() {
	// Support Featured Images.
	add_theme_support( 'post-thumbnails' );
	// New way of registering page title.
	add_theme_support( 'title-tag' );
	// Set text domain for translations.
	load_plugin_textdomain( 'tcb24', false, get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'tcb24_theme_setup' );



/**
 * Add theme's CSS file.
 */
function tcb24_css() {
	wp_enqueue_style( 'tcb24_style', get_stylesheet_uri(), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'tcb24_css', 1000, 'epkb-mp-frontend-category-layout-css' );



/**
 * Add body class for dark header.
 *
 * @param array $classes An array of body class names.
 */
function tcb24_custom_body_classes( $classes ) {
	// If custom field is set for dark header.
	if ( get_field( 'dark_header' ) ) {
		$classes[] = 'darkHeader';
	}
	// If custom field is set for dark header on posts page.
	$page_for_posts = get_option( 'page_for_posts' );
	if ( is_home() ) {
		if ( get_field( 'dark_header', $page_for_posts ) ) {
			$classes[] = 'darkHeader';
		}
	}
	// If we're in a single news post.
	if ( is_singular( 'post' ) ) {
		$classes[] = 'darkHeader';
	}
	// If we're on service record archive
	// if ( is_page_template( 'archive-service-record.php' ) ) {
	// $classes[] = 'darkHeader';
	// }
	if ( get_post_type() === 'service-record' && ! is_single() ) {
		$classes[] = 'darkHeader';
	}
	// If we're in a single service record post.
	if ( is_singular( 'service-record' ) ) {
		$classes[] = 'darkHeader';
	}
	// If we're in the wiki section.
	if ( is_page_template( 'page-template-template-wiki.php' ) ) {
		$classes[] = 'darkHeader';
	}
	if ( is_page_template( 'archive-epkb_post_type_1.php' ) ) {
		$classes[] = 'darkHeader';
	}
	if ( get_post_type() === 'epkb_post_type_1' && ! is_single() ) {
		$classes[] = 'darkHeader';
	}
	// If we're in a single wiki post.
	if ( is_singular( 'epkb_post_type_1' ) ) {
		$classes[] = 'darkHeader';
	}
	// If we're in a single event post.
	if ( is_singular( 'tribe_events' ) ) {
		$classes[] = 'darkHeader';
	}
	// If we're in search results page.
	if ( is_search() ) {
		$classes[] = 'darkHeader';
	}
	// If we're in 404 page.
	if ( is_404() ) {
		$classes[] = 'darkHeader';
	}
	if ( get_post_type() === 'post' && ! is_single() ) {
		$classes[] = 'darkHeader';
	}

	return $classes;
}

// add my custom class via body_class filter.
add_filter( 'body_class', 'tcb24_custom_body_classes' );



/**
 * Remove unwanted CSS files from plugins etc - find the handle in the plugin file and add here.
 */
function tcb24_remove_unwanted_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wc-blocks-style' );
	wp_dequeue_style( 'global-styles' );
	wp_deregister_style( 'classic-theme-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'tcb-roster' ); // Roster plugin styles are in main CSS file.
	wp_dequeue_style( 'epkb-mp-frontend-category-layout-css' ); // This doesn't work.
}
add_action( 'wp_enqueue_scripts', 'tcb24_remove_unwanted_css', 100 );


/**
 * Disable theme editing.
 */
define( 'DISALLOW_FILE_EDIT', true );

/**
 * Remove admin bar.
 */
show_admin_bar( false );


/**
 * Removes Top Level Menu - Comments, from all but admins and officers.
 */
function prefix_remove_comments_tl() {
	$user = wp_get_current_user();
	if ( in_array( 'administrator', $user->roles, true ) ) {
		return;
	}
	remove_menu_page( 'profile.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'edit.php?post_type=service-record' );
	remove_menu_page( 'edit.php?post_type=application' );
	remove_menu_page( 'edit.php?post_type=report' );
	remove_menu_page( 'edit.php?post_type=loa' );

	// These do not work -- attempts to remove acf global settings and field groups from menu.
	// remove_menu_page( 'edit.php?post_type=acf-field-group' );
	// remove_menu_page( 'edit.php?post_type=acf-options-global-settings' );

	if ( in_array( 'officer', $user->roles, true ) ) {
		return;
	}
	remove_menu_page( 'edit-comments.php' );
}

add_action( 'admin_menu', 'prefix_remove_comments_tl' );

/**
 * Custom events post type.
 */

// Display 5 posts on event archive page.
function sv_cpt_page( $query ) {
	if ( ! is_admin() && is_post_type_archive( 'tribe_events' ) ) {
		$query->set( 'posts_per_page', '2' );
	}
}
add_action( 'pre_get_posts', 'sv_cpt_page' );


/**
 * Pagination for archive, taxonomy, category, tag and search results pages
 *
 * @global $wp_query http://codex.wordpress.org/Class_Reference/WP_Query
 * @return Prints the HTML for the pagination if a template is $paged
 */
function sv_pagination( $event_direction ) {

	$next_arrow = is_rtl() ? esc_html( '<' ) : esc_html( '&laquo; Older events' );
	$prev_arrow = is_rtl() ? esc_html( '>' ) : esc_html( 'Newer events &raquo;' );

	global $wp_query, $event_query;
	if ( $event_query ) {
		$total = $event_query->max_num_pages;
	} else {
		$total = $wp_query->max_num_pages;
	}

	$big = 999999999; // This needs to be an unlikely integer

	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links

	if ( $event_direction === 'future' ) {
		$paginate_links = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $total,
				'show_all'  => true,
				'prev_text' => $next_arrow,
				'next_text' => $prev_arrow,
				'prev_next' => 'true',
			)
		);
	} else {
		$paginate_links = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $total,
				'show_all'  => true,
				'prev_text' => $prev_arrow,
				'next_text' => $next_arrow,
				'prev_next' => 'true',
			)
		);
	}
	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		print_r( $paginate_links );
	}
}



/**
 * AJAX search.
 */
function data_fetch() {
	// if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {.
	// die ( 'Busted!');.
	// }.
	if ( isset( $_POST['keyword'] ) ) {
		$searchterm = sanitize_text_field( wp_unslash( $_POST['keyword'] ) );
	}
	$the_query = new WP_Query(
		array(
			'posts_per_page' => -1,
			's'              => $searchterm,
			'post_type'      => array( 'epkb_post_type_1' ),
		)
	);
	if ( $the_query->have_posts() ) {
		echo '<ul>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post(); ?>
			<li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></li>
			<?php
		}
		echo '</ul>';
		wp_reset_postdata();
	} else {
		echo '<ul><li>Sorry, nothing found!</li></ul>';
	}
	die();
}
add_action( 'wp_ajax_data_fetch', 'data_fetch' );
add_action( 'wp_ajax_nopriv_data_fetch', 'data_fetch' );







/**
 * Remove link from author name in comments section.
 */
function tcb24_remove_author_url() {
	return '';
}
add_filter( 'get_comment_author_url', 'tcb24_remove_author_url', 10, 3 );

/**
 * Nicer comments section code.
 *
 * @param string $comment - comment content.
 * @param array  $args    - options.
 * @param var    $depth   - depth of comment tree.
 */
function tcb24_comment( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php
	if ( 'div' !== $args['style'] ) {
		?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php
	}
	?>
			<div class="comment-author vcard">
			<?php
			if ( 0 !== $args['avatar_size'] ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
			</div>
			<div class="comment-content">
				<?php
				printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() );
				if ( '0' === $comment->comment_approved ) {
					?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/>
					<?php
				}
				?>
				<div class="comment-meta commentmetadata">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf(
							__( '%1$s at %2$s' ),
							get_comment_date(),
							get_comment_time(),
						);
					?>
					</a>
					<?php
					edit_comment_link( __( '(Edit)' ), '  ', '' );
					?>
				</div>
				<?php comment_text(); ?>
				<div class="reply">
				<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => $add_below,
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							)
						)
					);
				?>
				</div>
			</div>
			<?php
			if ( 'div' !== $args['style'] ) :
				?>
		</div>
				<?php
	endif;
}


/**
 * Remove username, edit profile and log out as we use custom profile edit page
 *
 * @param array $defaults Description of the $defaults parameter.
 */
function wpdocs_comment_form_defaults( $defaults ) {
	$defaults['logged_in_as'] = '';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'wpdocs_comment_form_defaults' );




/**
 * Remove emoji junk.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );



/**
 * Remove jQuery migrate.
 *
 * @param array $scripts List of scripts loaded by WP.
 */
function tcb24_remove_jquery_migrate( &$scripts ) {
	if ( ! is_admin() ) {
		$scripts->remove( 'jquery' );
		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	}
}
add_filter( 'wp_default_scripts', 'tcb24_remove_jquery_migrate' );


/**
 * Add button class to blog pagination links.
 */
function tcb24_posts_link_attributes() {
	return 'class="btn"';
}
add_filter( 'next_posts_link_attributes', 'tcb24_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'tcb24_posts_link_attributes' );


/**
 * Custom read more function.
 */
function tcb24_custom_read_more() {
	return '... <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">Read more</a>';
}

/**
 * Custom excerpt - use echo excerpt(25); to output in theme.
 *
 * @param integer $limit Length of excerpt passed from get_the template tag.
 */
function excerpt( $limit ) {
	return wp_trim_words( get_the_excerpt(), $limit, tcb24_custom_read_more() );
}



/**
 * Register Main Menu.
 */
function tcb24_register_my_menu() {
	register_nav_menu( 'main-menu', __( 'Main Menu' ) );
}
add_action( 'init', 'tcb24_register_my_menu' );



/**
 * Register sidebars.
 */
function tcb24_sidebar_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', '3cb24' ),
			'id'            => 'blog-sidebar',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		),
	);
}
add_action( 'widgets_init', 'tcb24_sidebar_widgets_init' );



/**
 * Load Scripts Properly.
 */
function tcb24_scripts_method() {
	// Add FCS javascript.
	wp_register_script( 'fcs-script', get_template_directory_uri() . '/js/fcs-min.js', array( 'jquery' ), 1.0, true );
	wp_enqueue_script( 'fcs-script' );
}
add_action( 'wp_enqueue_scripts', 'tcb24_scripts_method' );



// Events stuff.
add_action(
	'tribe_template_before_include:events/v2/components/events-bar',
	function () {
		echo '<h1 id="eventListingTitle">Events</h1>';
	},
	10,
	3
);




/**
 * Add the custom columns to the book post type.
 */
function set_custom_edit_book_columns( $columns ) {
	unset( $columns['author'] );
	$columns['last_edit'] = __( 'Last edited', 'tcb24' );
	return $columns;
}
add_filter( 'manage_epkb_post_type_1_posts_columns', 'set_custom_edit_book_columns' );

/**
 * Add the data to the custom columns for the book post type.
 */
function custom_book_column() {
	if ( get_the_modified_date() !== get_the_date() ) {
		echo esc_html( get_the_modified_date( 'Y/m/d' ) . ' at ' . get_the_modified_time() );
	}
}
add_action( 'manage_epkb_post_type_1_posts_custom_column', 'custom_book_column', 10, 2 );



/**
 * Add ACF options page.
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( 'Global Settings' );
}



/**
 * Admin login page CSS.
 */
function tcb24_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/style-login.css', 1.0, true );
}
add_action( 'login_enqueue_scripts', 'tcb24_login_stylesheet' );



/**
 * Custom admin CSS to remove plugin ads etc.
 */
function tcb24_custom_admin_css() {
	wp_enqueue_style( 'custom_admin_css', get_template_directory_uri() . '/style-admin.css', array(), 1.0, false );
}
add_action( 'admin_head', 'tcb24_custom_admin_css' );


/**
 * Move Yoast to bottom of edit screen.
 */
function tcb24_yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'tcb24_yoasttobottom' );



/**
 * Callback function to insert styleselect into the buttons array.
 *
 * @param array $buttons List of buttons loaded by WP editor.
 */
function tcb24_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'tcb24_mce_buttons_2' );

/**
 * Set up additional styles for editor button
 *
 * @param array $settings List of settings loaded by WP editor.
 */
function tcb24_mce_before_init( $settings ) {
	$style_formats                           = array(
		array(
			'title'    => __( 'Positive', '3cb24' ),
			'selector' => 'p',
			'classes'  => 'positive',
		),
		array(
			'title'    => __( 'Error', '3cb24' ),
			'selector' => 'p',
			'classes'  => 'negative',
		),
		array(
			'title'    => __( 'Warning', '3cb24' ),
			'selector' => 'p',
			'classes'  => 'warning',
		),
		array(
			'title'    => __( 'Smaller text', '3cb24' ),
			'selector' => 'p',
			'classes'  => 'has-small-font-size',
		),
		array(
			'title'    => __( 'Larger text', '3cb24' ),
			'selector' => 'p',
			'classes'  => 'has-large-font-size',
		),
		array(
			'title'    => __( 'Button', '3cb24' ),
			'selector' => 'a',
			'classes'  => 'btn',
		),
	);
	$settings['style_formats']               = wp_json_encode( $style_formats );
	$settings['theme_advanced_blockformats'] = 'p,h3,h4';
	$settings['theme_advanced_disable']      = 'forecolor';

	return $settings;
}
add_filter( 'tiny_mce_before_init', 'tcb24_mce_before_init' );

/**
 * Add editor fonts/styles.
 */
function tcb24_theme_add_editor_styles() {
	add_editor_style( 'style-editor.css' );
}
add_action( 'init', 'tcb24_theme_add_editor_styles' );


/**
 * Remove WPCF7 stylesheet - we use our own styles in main CSS.
 */
add_filter( 'wpcf7_load_css', '__return_false' );



/**
 * Stop WPCF7 adding P tags to forms.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
