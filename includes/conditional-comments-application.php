<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Conditional comments
 *
 * @package 3cb24
 */

$role_list         = $args['role'];
$role_list_limited = $args['role_limited'];
$duration          = $args['duration'];

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

// Check if the user has the required role.
$roles = wp_get_current_user()->roles;

if ( ! empty( $role_list_limited ) ) {
	if ( array_intersect( $role_list_limited, $roles ) && in_array( $applicant_status, array( 'candidate', 'recruit', 'selection' ), true ) ) {
		comments_template( '/comments-application.php' );
		return;
	}
}

if ( ! empty( $role_list ) ) {
	if ( array_intersect( $role_list, $roles ) ) {
		comments_template( '/comments-application.php' );
		return;
	}
}
