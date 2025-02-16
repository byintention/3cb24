<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View an interview
 *
 * @package 3cb24
 */

$role_list     = $args['role'];
$status_       = $args['status'];
$type_         = $args['type'];
$display_field = $args['display_field'];
$type_lower    = strtolower( $type_ );

echo '<h2>' . esc_html( $status_ ) . '</h2>';

// Check if the user has the required role.
if ( ! empty( $role_list ) ) {
	$allow_entry = false;
	foreach ( $role_list as $role_ ) {
		if ( in_array( $role_, wp_get_current_user()->roles, true ) ) {
			$allow_entry = true;
			break;
		}
	}
	if ( ! $allow_entry ) {
		echo '<p class="negative">Not authorised</p>';
		return;
	}
}

$query_args = array(
	'post_type'              => $type_lower,
	'posts_per_page'         => -1,
	'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'tcb-status',
			'field'    => 'slug',
			'terms'    => $status_,
		),
	),
	'no_found_rows'          => true, // Improve performance by not counting total rows.
	'update_post_meta_cache' => false, // Improve performance by not updating post meta cache.
	'update_post_term_cache' => false, // Improve performance by not updating post term cache.
);

$posts_ = new WP_Query( $query_args );
if ( ! $posts_->have_posts() ) {
	echo '<p>No ' . esc_html( $status_ ) . ' ' . esc_html( $type_lower ) . 's</p>';
	return;
}

echo '<ul>';
while ( $posts_->have_posts() ) {
	$posts_->the_post();
	$post_id_     = get_the_ID();
	$user_data    = get_field( $display_field, $post_id_ );
	$display_name = $user_data['display_name'];
	echo '<li><a href="' . esc_url( home_url() ) . '/' . esc_html( $type_lower ) . '/' . esc_html( strtolower( $display_name ) ) . '">' . esc_html( $display_name ) . '</a>, posted on ' . esc_html( get_the_date( 'd-m-Y', $post_id_ ) ) . '</li>';
}
echo '</ul>';
wp_reset_postdata();
