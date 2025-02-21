<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * View an interview
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
	switch ( $field['name'] ) {
		case 'applicant':
			$applicant = get_field( 'applicant' );
			if ( ! $applicant ) {
				break;
			}
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $applicant->display_name ) . '</li><br>';
			break;
		case 'interviewers':
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>';
			$name_list = array();
			if ( ! is_array( $field['value'] ) ) {
				break;
			}
			foreach ( $field['value'] as $interviewer ) {
				$name_list[] = '<a href="' . add_query_arg( 'id', $interviewer['ID'], home_url() . '/user-info' ) . '">' . $interviewer['display_name'] . '</a>';
			}
			echo ( implode( ', ', $name_list ) ) . '</li><br>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;
		case 'Interview_evaluation':
			echo '<li><strong>' . esc_html( $field['label'] ) . ' </strong><br>' . esc_html( $field['value']['label'] ) . '</li><br>';
			break;
		default:
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
}
echo '</ol>';

echo '<p><a href="/edit-status/?id=' . esc_attr( $post_id_ ) . '" class="button button-secondary">Edit Status</a></p>';

// Early out for no applicant.
if ( ! $applicant->exists() ) {
	return;
}

$profile_id     = 'user_' . $applicant->ID;
$application_id = get_field( 'application', $profile_id );

if ( $application_id > 0 ) {
	$application_post = get_post( $application_id );
	if ( ! $application_post ) {
		return;
	}
	echo '<p><a href="/application/' . esc_attr( $application_post->post_name ) . '" class="button button-secondary">View Application</a></p>';
}
