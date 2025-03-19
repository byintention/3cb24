<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View of generic post
 *
 * @package 3cb24
 */

$role_list      = $args['role'];
$role_edit_list = $args['role_edit'];

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

$term_ = false;
if ( isset( $fields['tcb_selection']['value'][0] ) ) {
	$term_ = get_term_by( 'term_taxonomy_id', $fields['tcb_selection']['value'][0] );
}
if ( ! $term_ ) {
	$term_ = get_term_by( 'name', 'Submission phase', 'tcb-selection' );
}
$applicant_status = $term_->slug;
$term_description = $term_->description;
$term_name        = $term_->name;

echo '<h2>' . esc_html( $term_name ) . '</h2>';
echo '<p>' . esc_html( $term_description ) . '</p><br>';
echo '<h2>Application</h2>';
echo '<ol>';

$has_been_interviewed = false;
foreach ( $fields as $field ) {
	switch ( $field['name'] ) {
		case 'interviewers':
			echo '</ol><h2>Interview</h2><ol>';
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>';
			$name_list = array();
			if ( ! is_array( $field['value'] ) ) {
				break;
			}
			foreach ( $field['value'] as $interviewer ) {
				$name_list[] = '<a href="/service-record/service-record-' . $interviewer['ID'] . '">' . $interviewer['display_name'] . '</a>';
			}
			echo ( implode( ', ', $name_list ) ) . '</li><br>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;
		case 'Interview_evaluation':
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $field['value']['label'] ) . '</li><br>';
			$has_been_interviewed = true;
			break;
		case 'tcb_selection':
			break;
		default:
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $field['value'] ) . '</li><br>';
	}
}

echo '</ol>';

// Check if the user has the required role to edit.
$can_edit = false;
if ( ! empty( $role_edit_list ) ) {
	if ( array_intersect( $role_edit_list, $roles ) ) {
		$can_edit = true;
	}
}

// Get the user ID of the author.
$applicant_id = get_the_author_meta( 'ID' );
$applicant    = get_user_by( 'id', $applicant_id );

// Early out for no applicant.
if ( ! $applicant->exists() ) {
	echo '<p class="negative">No such applicant exists</p>';
	return;
}

if ( $can_edit ) {
	// Update selection status.
	echo '<p><a href="/edit-selection/?id=' . esc_attr( $post_id_ ) . '" class="button button-secondary">Edit Status</a></p>';
}

// Early out for applicant status set to Submission.
if ( 'submission' === $applicant_status ) {
	return;
}

if ( $can_edit ) {
	// Check if the user has been interviewed.
	if ( $has_been_interviewed ) {
		echo '<p><a href="/hidden/edit-interview/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Edit Interview</a></p>';
	} else {
		echo '<p><a href="/hidden/edit-interview/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Create Interview</a></p>';
	}
}

// Early out for applicant status set to Pending or Rejected.
if ( in_array( $applicant_status, array( 'submission', 'interview', 'candidate' ), true ) ) {
	return;
}

$profile_id        = 'user_' . $applicant_id;
$service_record_id = get_field( 'service_record', $profile_id );

// Early out for applicant status set to Rejected.
if ( 'rejected' === $applicant_status ) {
	tcbp_public_sr_check_demotion_to_subscriber( $applicant_id, $service_record_id );
	return;
}

if ( $service_record_id > 0 ) {
	$service_record_post = get_post( $service_record_id );
	if ( ! $service_record_post ) {
		echo '<p class="negative">No such service record exists</p>';
		return;
	}
	echo '<p><a href="/service-record/' . esc_attr( $service_record_post->post_name ) . '" class="button button-secondary">View Service Record</a></p>';

	if ( $can_edit ) {
		echo '<p><a href="/hidden/service-record/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Edit Service Record</a></p>';
	}
} elseif ( $can_edit ) {
	echo '<p><a href="/hidden/service-record/?id=' . esc_attr( $applicant_id ) . '" class="button button-secondary">Create Service Record</a></p>';
}

if ( 'archived' === $applicant_status ) {
	tcbp_public_sr_check_promotion_to_marine( $applicant_id, $service_record_id );
	return;
}
