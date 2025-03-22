<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Main view of the service record
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

echo '<h3>User Info</h3>';

$allowed_full_roles = array( 'officer', 'administrator' );
$has_full_access    = array_intersect( $allowed_full_roles, $roles );

$allowed_partial_roles = array( 'training_admin', 'commendation_admin', 'recruit_admin', 'snco', 'officer', 'administrator' );
$has_partial_access    = array_intersect( $allowed_partial_roles, $roles );

$allowed_ribbon_roles = array( 'commendation_admin', 'snco', 'officer', 'administrator' );
$has_ribbon_access    = array_intersect( $allowed_ribbon_roles, $roles );

$allowed_training_roles = array( 'training_admin', 'snco', 'officer', 'administrator' );
$has_training_access    = array_intersect( $allowed_training_roles, $roles );

$allowed_recruit_roles = array( 'recruit_admin', 'snco', 'officer', 'administrator' );
$has_recruit_access    = array_intersect( $allowed_recruit_roles, $roles );

$post_id_ = get_the_ID();
$user_id  = get_field( 'user_id', $post_id_ );
$user     = get_user_by( 'id', $user_id );

// Early out for no user.
if ( ! $user ) {
	echo '<p>Error: No user for service record ' . esc_attr( $post_id_ ) . '</p>';
	return;
}
$display_name = $user->get( 'display_name' );
$profile_id   = 'user_' . $user_id;

// Rank.
$rank_path = plugins_url() . '/tcb-roster/images/ranks/';
$terms     = get_the_terms( $post_id_, 'tcb-rank' );
if ( ! $terms || ! $terms[0] ) {
	echo '<p>Error: No rank</p>';
	return;
}
$rank_name = $terms[0]->name;
$rank_slug = $terms[0]->slug;

echo '<p><img src="' . esc_attr( $rank_path ) . esc_attr( $rank_slug ) . '.gif", title="' . esc_html( $rank_name ) . '", width="144", height="240"></p>';

echo '<table>';
echo '<tr><td>Rank</td><td>' . esc_attr( $rank_name ) . '</td></tr>';

// First Name.
$first_name = $user->get( 'first_name' );
if ( $has_full_access && $first_name ) {
	echo '<tr><td>First Name</td><td>' . esc_attr( $first_name ) . '</td></tr>';
}

// Location.
$location = get_field( 'user-location', $profile_id );
if ( $location ) {
	echo '<tr><td>Location</td><td>' . esc_attr( $location ) . '</td></tr>';
}

// Discord ID.
$discord_id = get_field( 'discord_id', $profile_id );
if ( $has_partial_access && $discord_id ) {
	echo '<tr><td>Discord ID</td><td>' . esc_attr( $discord_id ) . '</td></tr>';
}

// Email.
$email = $user->user_email;
if ( $has_partial_access && $email ) {
	echo '<tr><td>Email</td><td>' . esc_attr( $email ) . '</td></tr>';
}

// Dates.
if ( 'Rct' === $rank_slug ) {
	$date_str = get_field( 'attestation_date', $post_id_ );
	$date     = DateTime::createFromFormat( 'd/m/Y', $date_str );
	if ( $date ) {
		$now      = new DateTime( 'now' );
		$interval = $date->diff( $now );
		echo '<tr><td>Attestation</td><td>' . esc_attr( date_format( $date, 'd-m-Y' ) ) . '</td></tr>';
		echo '<tr><td>Length of recruit period</td><td>' . esc_attr( $interval->format( '%y year(s), %m month(s), %d day(s)' ) ) . '</td></tr>';
	}
} else {
	$date_str = get_field( 'passing_out_date', $post_id_ );
	$date     = DateTime::createFromFormat( 'd/m/Y', $date_str );
	if ( $date ) {
		$now      = new DateTime( 'now' );
		$interval = $date->diff( $now );
		echo '<tr><td>Passing out</td><td>' . esc_attr( date_format( $date, 'd-m-Y' ) ) . '</td></tr>';
		echo '<tr><td>Length of service</td><td>' . esc_attr( $interval->format( '%y year(s), %m month(s), %d day(s)' ) ) . '</td></tr>';
	}
}
// LOA.
if ( ( 1 === get_field( 'loa', $post_id_ ) ) && ( 'Res' !== $rank['value'] ) ) {
	echo '<tr><td>Approved LOA</td></tr>';
}

echo '</table>';

echo '<div class = "tcb_user_edit_options" >';

if ( $has_training_access ) {
	echo '<p><a href="' . esc_attr( home_url() ) . '/edit-sr-training/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit Training Record</a></p>';
}
if ( $has_ribbon_access ) {
	echo '<p><a href="' . esc_attr( home_url() ) . '/edit-sr-ribbons/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit Commendations</a></p>';
}
if ( $has_recruit_access ) {
	echo '<p><a href="' . esc_attr( home_url() ) . '/edit-sr-info/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit User Info</a></p>';
}
if ( $has_training_access ) {
	$application_id = get_field( 'application', $profile_id );
	if ( $application_id > 0 ) {
		$application_post = get_post( $application_id );
		if ( $application_post ) {
			echo '<p><a href="/application/' . esc_attr( $application_post->post_name ) . '" class="button button-secondary">View Application</a></p>';
		}
	}
}

echo '</div>';
