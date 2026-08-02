<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View an Service Record
 *
 * @package 3cb24
 */

$role_list = $args['role'];
$rank      = $args['rank'];

echo '<h2>' . esc_html( $rank ) . '</h2>';

$term_ = get_term_by( 'name', $rank, 'tcb-rank' );
echo '<p>' . esc_html( $term_->description ) . '</p>';

// Check if the user has the required role.
$view_access = true;
$roles       = wp_get_current_user()->roles;
if ( ! empty( $role_list ) ) {
	if ( ! array_intersect( $role_list, $roles ) ) {
		$view_access = false;
		// Not authorised to view this service record.
	}
}

// Early exit if no view access and rank is Reserve.
if ( ! $view_access && 'Reserve' === $rank ) {
	return;
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
	echo '<div class="info">No ' . esc_html( $rank ) . ' service records</div>';
	return;
}

// Display name lives on the WP user, not the service-record post, so it can't be sorted via
// WP_Query's own orderby - collect it here and sort afterwards instead.
$roster_entries = array();
while ( $posts_->have_posts() ) {
	$posts_->the_post();
	$post_id_ = get_the_ID();
	$user_id  = get_field( 'user_id', $post_id_ );
	$user     = get_user_by( 'id', $user_id );
	if ( ! $user ) {
		continue;
	}
	$roster_entries[] = array(
		'display_name' => $user->get( 'display_name' ),
		'permalink'    => get_permalink(),
	);
}
wp_reset_postdata();

usort(
	$roster_entries,
	function ( $a, $b ) {
		return strcasecmp( $a['display_name'], $b['display_name'] );
	}
);

echo '<ul>';
foreach ( $roster_entries as $entry ) {
	if ( $view_access ) {
		// User has access to view the service record.
		echo '<li><a href="' . esc_url( $entry['permalink'] ) . '">' . esc_html( $entry['display_name'] ) . '</a></li>';
	} else {
		echo '<li>' . esc_html( $entry['display_name'] ) . '</li>';
	}
}
echo '</ul>';
