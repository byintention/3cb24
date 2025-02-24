<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View an Service Record
 *
 * @package 3cb24
 */

$role_list = $args['role'];
$duty      = $args['duty'];
$info_     = $args['info'];

echo '<h2>' . esc_html( $duty ) . '</h2>';
echo '<p>' . esc_html( $info_ ) . '</p>';

// Check if the user has the required role.
$roles = wp_get_current_user()->roles;
if ( ! empty( $role_list ) ) {
	if ( ! array_intersect( $role_list, $roles ) ) {
		echo '<p class="negative">Not authorised</p>';
		return;
	}
}

$query_args = array(
	'post_type'              => 'service-record',
	'posts_per_page'         => -1,
	'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'tcb-rank',
			'field'    => 'name',
			'terms'    => $rank,
		),
	),
	'no_found_rows'          => true, // Improve performance by not counting total rows.
	'update_post_meta_cache' => false, // Improve performance by not updating post meta cache.
	'update_post_term_cache' => false, // Improve performance by not updating post term cache.
);

$posts_ = new WP_Query( $query_args );
if ( ! $posts_->have_posts() ) {
	echo '<p>No ' . esc_html( $duty ) . ' </p>';
	return;
}

echo '<ul>';
while ( $posts_->have_posts() ) {
	$posts_->the_post();
	$post_id_ = get_the_ID();
	$user_id  = get_field( 'user_id', $post_id_ );
	$user     = get_user_by( 'id', $user_id );
	if ( ! $user ) {
		continue;
	}
	$display_name = $user->get( 'display_name' );
	echo '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( $display_name ) . '</a></li>';
}
echo '</ul>';
wp_reset_postdata();
