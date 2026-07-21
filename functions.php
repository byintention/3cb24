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
	// If custom field is ticked for light header.
	if ( get_field( 'light_header' ) ) {
		$classes[] = 'lightHeader';
	}
	
	if ( get_post_type() === 'tribe_events' && ! is_single() ) {
		$classes[] = 'lightHeader';
	}

	// Dark header is now default, removed other conditionals here Oct 25.

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
	remove_menu_page( 'index.php' );

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
 * Wiki access control.
 *
 * Access is defined per epkb_post_type_1_category term (via an "allowed_roles" term meta field
 * managed below), not per article - a category with no allowed_roles configured, or an article
 * with no category, defaults to officer/administrator only (fails closed). An article assigned
 * to multiple categories requires the user to qualify for every one of them (most restrictive
 * wins).
 */

define( 'TCB24_WIKI_TAXONOMY', 'epkb_post_type_1_category' );
define( 'TCB24_WIKI_DEFAULT_ALLOWED_ROLES', array( 'officer', 'administrator' ) );

add_action( TCB24_WIKI_TAXONOMY . '_add_form_fields', 'tcb24_wiki_category_allowed_roles_add_field' );
add_action( TCB24_WIKI_TAXONOMY . '_edit_form_fields', 'tcb24_wiki_category_allowed_roles_edit_field' );
add_action( 'create_' . TCB24_WIKI_TAXONOMY, 'tcb24_wiki_category_save_allowed_roles' );
add_action( 'edited_' . TCB24_WIKI_TAXONOMY, 'tcb24_wiki_category_save_allowed_roles' );

/**
 * Renders the allowed-roles checkboxes on the "Add Category" screen.
 */
function tcb24_wiki_category_allowed_roles_add_field() {
	?>
	<div class="form-field">
		<label><?php esc_html_e( 'Allowed Roles', 'tcb24' ); ?></label>
		<?php tcb24_wiki_category_allowed_roles_checkboxes( array() ); ?>
		<p class="description"><?php esc_html_e( 'Roles allowed to view wiki articles in this category. Leave all unchecked to restrict to officers/administrators only.', 'tcb24' ); ?></p>
	</div>
	<?php
}

/**
 * Renders the allowed-roles checkboxes on the "Edit Category" screen.
 *
 * @param WP_Term $term The category term being edited.
 */
function tcb24_wiki_category_allowed_roles_edit_field( $term ) {
	$allowed_roles = get_term_meta( $term->term_id, 'allowed_roles', true );
	$allowed_roles = is_array( $allowed_roles ) ? $allowed_roles : array();
	?>
	<tr class="form-field">
		<th scope="row"><label><?php esc_html_e( 'Allowed Roles', 'tcb24' ); ?></label></th>
		<td>
			<?php tcb24_wiki_category_allowed_roles_checkboxes( $allowed_roles ); ?>
			<p class="description"><?php esc_html_e( 'Roles allowed to view wiki articles in this category. Leave all unchecked to restrict to officers/administrators only.', 'tcb24' ); ?></p>
		</td>
	</tr>
	<?php
}

/**
 * Outputs one checkbox per registered WordPress role.
 *
 * @param string[] $selected_roles Role slugs already selected for this term.
 */
function tcb24_wiki_category_allowed_roles_checkboxes( $selected_roles ) {
	foreach ( get_editable_roles() as $role_slug => $role_info ) {
		?>
		<label style="display:block;">
			<input type="checkbox" name="tcb24_allowed_roles[]" value="<?php echo esc_attr( $role_slug ); ?>" <?php checked( in_array( $role_slug, $selected_roles, true ) ); ?>>
			<?php echo esc_html( $role_info['name'] ); ?>
		</label>
		<?php
	}
}

/**
 * Saves the allowed-roles term meta. The category add/edit screens already carry WordPress
 * core's own nonce for term saves, verified before create_/edited_ fire.
 *
 * @param int $term_id The category term ID being saved.
 */
function tcb24_wiki_category_save_allowed_roles( $term_id ) {
	if ( empty( $_POST['tcb24_allowed_roles'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		delete_term_meta( $term_id, 'allowed_roles' );
		return;
	}
	$roles = array_map( 'sanitize_key', wp_unslash( $_POST['tcb24_allowed_roles'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
	update_term_meta( $term_id, 'allowed_roles', $roles );
}

/**
 * Builds a map of every wiki category term ID that has its OWN explicitly configured
 * allowed_roles. A term with nothing set is simply absent from this map - that distinction
 * (configured vs. blank) is what lets tcb24_wiki_resolve_effective_roles() tell "explicitly
 * restricted to these roles" apart from "inherit whatever the parent resolves to". Use
 * tcb24_wiki_get_effective_category_role_map() for actual permission checks; this is just the
 * raw, per-term building block for it.
 *
 * @return array<int, string[]> Term ID => explicitly configured allowed role slugs.
 */
function tcb24_wiki_get_category_role_map() {
	$terms = get_terms(
		array(
			'taxonomy'   => TCB24_WIKI_TAXONOMY,
			'hide_empty' => false,
		)
	);
	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$map = array();
	foreach ( $terms as $term ) {
		$allowed_roles = get_term_meta( $term->term_id, 'allowed_roles', true );
		if ( is_array( $allowed_roles ) && ! empty( $allowed_roles ) ) {
			$map[ $term->term_id ] = $allowed_roles;
		}
	}

	return $map;
}

/**
 * Resolves a single wiki category's effective allowed roles, applying the parent-as-ceiling
 * rule: a category explicitly configured with its own allowed_roles is capped by (intersected
 * with) its parent's effective roles, so it can never be more open than an ancestor. A category
 * left blank doesn't fall back to TCB24_WIKI_DEFAULT_ALLOWED_ROLES directly - it inherits its
 * parent's effective roles outright, so leaving a subcategory blank means "same access as its
 * parent", not "officer/admin only". Only a term with no parent (or a whole unconfigured chain
 * up to the root) resolves to the site-wide default. Recursive, with memoization via $cache
 * since multiple sibling terms share the same ancestor chain.
 *
 * @param int   $term_id The category term ID to resolve.
 * @param array $own_map Term ID => own configured roles, from tcb24_wiki_get_category_role_map().
 * @param array $cache   Memoization cache, keyed by term ID, passed by reference and filled in as
 *                        terms are resolved.
 * @return string[] The effective allowed role slugs for this term.
 */
function tcb24_wiki_resolve_effective_roles( $term_id, $own_map, &$cache ) {
	if ( isset( $cache[ $term_id ] ) ) {
		return $cache[ $term_id ];
	}

	$term      = get_term( $term_id, TCB24_WIKI_TAXONOMY );
	$parent_id = ( $term && ! is_wp_error( $term ) ) ? (int) $term->parent : 0;
	$has_own   = ! empty( $own_map[ $term_id ] );

	if ( ! $parent_id ) {
		$effective = $has_own ? $own_map[ $term_id ] : TCB24_WIKI_DEFAULT_ALLOWED_ROLES;
	} else {
		$parent_effective = tcb24_wiki_resolve_effective_roles( $parent_id, $own_map, $cache );
		$effective        = $has_own ? array_intersect( $own_map[ $term_id ], $parent_effective ) : $parent_effective;
	}

	$cache[ $term_id ] = $effective;
	return $effective;
}

/**
 * Builds a map of every wiki category term ID to its effective allowed roles (see
 * tcb24_wiki_resolve_effective_roles() for the resolution rules). Memoized for the duration of
 * the request - the map only depends on the category tree and the current user, neither of
 * which change mid-request, but this can otherwise be called many times per page (once per
 * article, plus once per category link in a listing), so it's worth not recomputing it - a
 * get_terms() call plus a get_term_meta() lookup per category - every time.
 *
 * @return array<int, string[]> Term ID => effective allowed role slugs.
 */
function tcb24_wiki_get_effective_category_role_map() {
	static $effective_map = null;
	if ( null !== $effective_map ) {
		return $effective_map;
	}

	$term_ids = get_terms(
		array(
			'taxonomy'   => TCB24_WIKI_TAXONOMY,
			'hide_empty' => false,
			'fields'     => 'ids',
		)
	);
	if ( is_wp_error( $term_ids ) ) {
		return array();
	}

	$own_map       = tcb24_wiki_get_category_role_map();
	$cache         = array();
	$effective_map = array();
	foreach ( $term_ids as $term_id ) {
		$effective_map[ $term_id ] = tcb24_wiki_resolve_effective_roles( $term_id, $own_map, $cache );
	}

	return $effective_map;
}

/**
 * Determines whether the current user is blocked from a specific wiki category - used to hide
 * category/subcategory links in navigation (the "Information Centre" hub and category pages)
 * that the user has no access to, rather than showing a link that leads to an empty or blocked
 * page.
 *
 * @param int $term_id The category term ID.
 * @return bool True if the current user is blocked from this category.
 */
function tcb24_wiki_is_category_restricted_for_user( $term_id ) {
	// Site administrators always have full access, regardless of what a category or article's
	// own restriction list says - matches how the Members plugin itself treats admins.
	if ( current_user_can( 'manage_options' ) ) {
		return false;
	}

	$user_roles    = wp_get_current_user()->roles;
	$category_map  = tcb24_wiki_get_effective_category_role_map();
	$allowed_roles = isset( $category_map[ $term_id ] ) ? $category_map[ $term_id ] : TCB24_WIKI_DEFAULT_ALLOWED_ROLES;

	return ! array_intersect( $allowed_roles, $user_roles );
}

/**
 * Gets the roles explicitly allowed for a specific wiki article via the Members plugin's own
 * per-post "_members_access_role" meta, if set. This is the old, per-article restriction system
 * the category-based scheme was meant to replace, but some articles still carry it. Where
 * present, it applies ON TOP OF the category-based rules as an extra, more restrictive
 * requirement - it doesn't get overridden by whatever the categories would otherwise allow.
 *
 * @param int $post_id The wiki article post ID.
 * @return string[] Explicitly allowed role slugs, or an empty array if this article has no
 *                   per-article restriction set.
 */
function tcb24_wiki_get_article_own_allowed_roles( $post_id ) {
	$roles = get_post_meta( $post_id, '_members_access_role', false );
	return is_array( $roles ) ? array_filter( $roles ) : array();
}

/**
 * Determines whether the current user is blocked from a specific wiki article. A per-article
 * Members-plugin restriction, if set, is checked first and wins outright if it doesn't match -
 * see tcb24_wiki_get_article_own_allowed_roles(). Otherwise, an article assigned to multiple
 * categories uses "least restrictive wins": the user only needs to qualify for at least one of
 * them, not every one.
 *
 * @param int $post_id The wiki article post ID.
 * @return bool True if the current user is blocked from this article.
 */
function tcb24_wiki_is_restricted_for_user( $post_id ) {
	// Site administrators always have full access, regardless of what a category or article's
	// own restriction list says - matches how the Members plugin itself treats admins.
	if ( current_user_can( 'manage_options' ) ) {
		return false;
	}

	$user_roles = wp_get_current_user()->roles;

	$article_own_roles = tcb24_wiki_get_article_own_allowed_roles( $post_id );
	if ( $article_own_roles && ! array_intersect( $article_own_roles, $user_roles ) ) {
		return true;
	}

	$category_map = tcb24_wiki_get_effective_category_role_map();
	$terms        = get_the_terms( $post_id, TCB24_WIKI_TAXONOMY );

	if ( ! $terms || is_wp_error( $terms ) ) {
		// No category assigned - fail closed to the site-wide default.
		return ! array_intersect( TCB24_WIKI_DEFAULT_ALLOWED_ROLES, $user_roles );
	}

	foreach ( $terms as $term ) {
		$allowed_roles = isset( $category_map[ $term->term_id ] ) ? $category_map[ $term->term_id ] : TCB24_WIKI_DEFAULT_ALLOWED_ROLES;
		if ( array_intersect( $allowed_roles, $user_roles ) ) {
			// Qualifies via this one category - no need to check the rest.
			return false;
		}
	}

	return true;
}

add_action( 'pre_get_posts', 'tcb24_wiki_restrict_query' );

/**
 * Excludes wiki articles the current user isn't allowed to see from any query targeting the
 * wiki post type - covers the archive, category, and search-page listings, and the data_fetch
 * AJAX search, in one place rather than needing a separate check in every template. Skipped for
 * genuine wp-admin screen loads (post list/edit) but NOT for AJAX requests, since admin-ajax.php
 * requests (including data_fetch, a front-end search) also report is_admin() as true.
 *
 * An article assigned to multiple categories uses "least restrictive wins" - a post is included
 * as soon as it has at least one allowed category, regardless of what its other categories say
 * (matching tcb24_wiki_is_restricted_for_user()). An uncategorized post is included only if the
 * user qualifies for the site-wide default. A post carrying the Members plugin's own per-post
 * "_members_access_role" meta is additionally required to match one of the user's roles there
 * too - that old, per-article system isn't overridden by the category rules, it's layered under
 * them (see tcb24_wiki_get_article_own_allowed_roles()).
 *
 * @param WP_Query $query The query being filtered.
 */
function tcb24_wiki_restrict_query( $query ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}
	if ( ! in_array( 'epkb_post_type_1', (array) $query->get( 'post_type' ), true ) ) {
		return;
	}

	// Site administrators always have full access - don't touch the query for them at all.
	if ( current_user_can( 'manage_options' ) ) {
		return;
	}

	$user_roles = wp_get_current_user()->roles;

	// Per-article Members-plugin restriction, if set on a given post: exclude it unless one of
	// the user's roles is explicitly listed. Posts with no such meta are untouched here - the
	// category-based tax_query below is what governs those.
	$meta_query   = (array) $query->get( 'meta_query' );
	$meta_query[] = array(
		'relation' => 'OR',
		array(
			'key'     => '_members_access_role',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key'     => '_members_access_role',
			'value'   => $user_roles ? $user_roles : array( '' ),
			'compare' => 'IN',
		),
	);
	$query->set( 'meta_query', $meta_query );

	$allowed_term_ids = array();
	foreach ( tcb24_wiki_get_effective_category_role_map() as $term_id => $allowed_roles ) {
		if ( array_intersect( $allowed_roles, $user_roles ) ) {
			$allowed_term_ids[] = $term_id;
		}
	}

	$user_has_default_access = (bool) array_intersect( TCB24_WIKI_DEFAULT_ALLOWED_ROLES, $user_roles );

	$tax_query_or = array( 'relation' => 'OR' );
	if ( $allowed_term_ids ) {
		$tax_query_or[] = array(
			'taxonomy' => TCB24_WIKI_TAXONOMY,
			'field'    => 'term_id',
			'terms'    => $allowed_term_ids,
			'operator' => 'IN',
		);
	}
	if ( $user_has_default_access ) {
		// Uncategorized posts fail closed to the default too - include them only if this user
		// actually qualifies for it.
		$tax_query_or[] = array(
			'taxonomy' => TCB24_WIKI_TAXONOMY,
			'operator' => 'NOT EXISTS',
		);
	}

	if ( count( $tax_query_or ) <= 1 ) {
		// No accessible categories and no default access - nothing to show this user.
		$query->set( 'post__in', array( 0 ) );
		return;
	}

	$tax_query   = (array) $query->get( 'tax_query' );
	$tax_query[] = $tax_query_or;
	$query->set( 'tax_query', $tax_query );
}

add_action( 'template_redirect', 'tcb24_wiki_block_restricted_single_article' );

/**
 * Blocks direct access to a wiki article the current user isn't allowed to see, showing an
 * access-denied message rather than the article content. tcb24_wiki_restrict_query() already
 * keeps restricted articles out of listings/search, but a direct URL still needs its own check.
 */
function tcb24_wiki_block_restricted_single_article() {
	if ( ! is_singular( 'epkb_post_type_1' ) ) {
		return;
	}

	if ( ! tcb24_wiki_is_restricted_for_user( get_queried_object_id() ) ) {
		return;
	}

	wp_die(
		esc_html__( 'You do not have permission to view this wiki article.', 'tcb24' ),
		esc_html__( 'Access Denied', 'tcb24' ),
		array( 'response' => 403 )
	);
}







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

	// Show event start times converted to the visitor's own browser timezone.
	if ( is_singular( 'tribe_events' ) ) {
		wp_register_script( 'event-local-time', get_template_directory_uri() . '/js/event-local-time.js', array(), 1.0, true );
		wp_enqueue_script( 'event-local-time' );
	}
}
add_action( 'wp_enqueue_scripts', 'tcb24_scripts_method' );



// Events stuff.

/**
 * Formats a time stored in ACF's 12-hour "g:i a" format (e.g. "7:30 pm") as 24-hour "H:i" for
 * display. The stored format itself is left alone since tcb-roster's mission scheduling code
 * parses it as "g:i a" - this only affects how the time is shown on the page.
 *
 * @param string $time_12h Time string in "g:i a" format.
 * @return string Time in 24-hour "H:i" format, or the original string if it can't be parsed.
 */
function tcb24_format_24_hour_time( $time_12h ) {
	$time = DateTime::createFromFormat( 'g:i a', $time_12h );
	return $time ? $time->format( 'H:i' ) : $time_12h;
}
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
 * Add ACF options page, once ACF has fully initialized rather than whenever functions.php
 * happens to load relative to the plugins - acf_add_options_page() being defined isn't the
 * same as ACF being ready for it to be called.
 */
add_action( 'acf/init', 'tcb24_add_acf_options_page' );

/**
 * Registers the ACF Global Settings options page.
 */
function tcb24_add_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( 'Global Settings' );
	}
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
	$settings['style_formats']               = json_encode( $style_formats );
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
