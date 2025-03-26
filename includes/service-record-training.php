<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Training view of the service record
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

echo '<h3>Training Completed</h3>';

$list_of_courses = get_field( 'courses_completed' );
if ( $list_of_courses ) {
	echo '<ul>';
	foreach ( $list_of_courses as $course ) {
		echo '<li>' . esc_attr( $course['label'] ) . '</li>';
	}
	echo '</ul>';
}

// Duties.
$list_of_duties = get_field( 'duties' );
if ( $list_of_duties ) {
	echo '<h3>Administrative duties</h3>';

	echo '<ul>';
	foreach ( $list_of_duties as $duty ) {
		if ( is_array( $duty ) ) {
			$term_ = get_term_by( 'term_id', $duty['value'], 'tcb-duty' );
		} else {
			$term_ = get_term_by( 'term_id', $duty, 'tcb-duty' );
		}
		echo '<li>' . esc_attr( $term_->name ) . '</li>';
	}

	echo '</ul>';
}
