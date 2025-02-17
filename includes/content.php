<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View of generic post
 *
 * @package 3cb24
 */

$role_list = $args['role'];

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

$post_id_ = get_the_ID();

// Early exit if the post ID is not set.
$fields = get_field_objects( $post_id_ );
if ( ! $fields ) {
	return;
}

echo '<ol>';

foreach ( $fields as $field ) {
	if ( 'Status' === $field['label'] ) {
		echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>';
		$terms = get_the_terms( $post_id_, 'tcb-status' );
		if ( $terms ) {
			foreach ( $terms as $term_ ) {
				echo esc_html( $term_->name );
			}
		}
		echo '</li><br>';
	} else {
		echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $field['value'] ) . '</li><br>';
	}
}

echo '</ol>';

echo '<p><a href="/edit-status/?id=' . esc_attr( $post_id_ ) . '" class="button button-secondary">Edit Status</a></p>';
