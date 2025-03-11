<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View an interview
 *
 * @package 3cb24
 */

$role_list = $args['role'];

// Check if the user has the required role.
$roles = wp_get_current_user()->roles;
if ( ! empty( $role_list ) ) {
	if ( ! array_intersect( $role_list, $roles ) ) {
		echo '<p class="negative">Not authorised</p>';
		return;
	}
}

$terms = get_terms(
	array(
		'taxonomy'   => 'tcb-selection',
		'hide_empty' => false,
	),
);

if ( empty( $terms ) ) {
	echo '<p class="negative">Taxonomy missing</p>';
	return;
}

foreach ( $terms as $term_ ) {
	$term_id          = $term_->term_id;
	$term_name        = $term_->name;
	$term_slug        = $term_->slug;
	$term_description = $term_->description;

	$query_args = array(
		'post_type'              => 'application',
		'posts_per_page'         => -1,
		'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'tcb-selection',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
		'no_found_rows'          => true, // Improve performance by not counting total rows.
		'update_post_meta_cache' => false, // Improve performance by not updating post meta cache.
		'update_post_term_cache' => false, // Improve performance by not updating post term cache.
	);

	$posts_ = new WP_Query( $query_args );
	if ( ! $posts_->have_posts() ) {
		continue;
	}

	echo '<div class="post white" id="post-' . esc_attr( get_the_ID() ) . '" >';
	echo '<div class="entry padded">';
	echo '<h2>' . esc_html( $term_name ) . '</h2>';
	echo '<p>' . esc_html( $term_description ) . '</p>';

	echo '<ul>';
	while ( $posts_->have_posts() ) {
		$posts_->the_post();
		$post_id_ = get_the_ID();
		echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>, posted on ' . esc_html( get_the_date( 'd-m-Y', $post_id_ ) ) . '</li>';
	}
	echo '</ul>';
	wp_reset_postdata();

	echo '</div>';
	echo '</div>';
}
