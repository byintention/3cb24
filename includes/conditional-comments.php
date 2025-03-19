<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Conditional comments
 *
 * @package 3cb24
 */

$role_list   = $args['role'];
$comment_php = $args['comment_php'];
$duration    = $args['duration'];

// Check if the user has the required role.
$roles = wp_get_current_user()->roles;
if ( ! empty( $role_list ) ) {
	if ( ! array_intersect( $role_list, $roles ) ) {
		return;
	}
}

// Check if all comments for this post have timed out.
if ( '' !== $duration && 0 < $duration ) {
	$post_date            = get_the_date( 'Y-m-d' );
	$current_date         = gmdate( 'Y-m-d' );
	$datetime1            = new DateTime( $post_date );
	$datetime2            = new DateTime( $current_date );
	$interval             = $datetime1->diff( $datetime2 );
	$days_since_published = $interval->days;

	if ( $days_since_published > $duration ) {
		return;
	}
}

comments_template( $comment_php );
