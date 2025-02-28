<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View of generic post
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
				$applicant_status = $term_->name;
				echo esc_html( $applicant_status );
			}
		}
		echo '</li><br>';
	} else {
		echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $field['value'] ) . '</li><br>';
	}
}

echo '</ol>';

echo '<p><a href="/edit-status/?id=' . esc_attr( $post_id_ ) . '" class="button button-secondary">Edit Status</a></p>';

// Get the user ID of the author.
$applicant_id = get_the_author_meta( 'ID' );
$applicant    = get_user_by( 'id', $applicant_id );

// Early out for no applicant.
if ( ! $applicant->exists() ) {
	return;
}

$profile_id   = 'user_' . $applicant_id;
$interview_id = get_field( 'interview', $profile_id );

if ( $interview_id > 0 ) {
	$interview_post = get_post( $interview_id );
	if ( ! $interview_post ) {
		return;
	}
	echo '<p><a href="/interview/' . esc_attr( $interview_post->post_name ) . '" class="button button-secondary">View Interview</a></p>';
} else {
	echo '<p><a href="/hidden/interview/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Create Interview</a></p>';
}

// Early out for applicant status set to Pending or Rejected.
if ( ( 'Pending' === $applicant_status ) || ( 'Rejected' === $applicant_status ) ) {
	return;
}

$service_record_id = get_field( 'service_record', $profile_id );

if ( $service_record_id > 0 ) {
	$service_record_post = get_post( $service_record_id );
	if ( ! $service_record_post ) {
		return;
	}
	echo '<p><a href="/service-records/' . esc_attr( $service_record_post->post_name ) . '" class="button button-secondary">View Service Record</a></p>';

	echo '<p><a href="/hidden/service-record/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Edit Service Record</a></p>';
} else {
	echo '<p><a href="/hidden/service-record/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Create Service Record</a></p>';
}

if ( 'Archived' === $applicant_status ) {
	tcbp_public_sr_check_promotion_to_marine( $applicant_id, $service_record_id );
	return;
}
