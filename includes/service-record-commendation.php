<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Commendations view of the service record
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

echo '<h3>Commendations</h3>';

$ribbon_path = plugins_url() . '/tcb-roster/images/ribbons/';
$date_str    = get_field( 'passing_out_date' );
$date        = DateTime::createFromFormat( 'd/m/Y', $date_str );

if ( $date ) {
	$now          = new DateTime( 'now' );
	$interval     = $date->diff( $now );
	$served_years = $interval->y;
	if ( $served_years > 0 ) {
		echo '<p><img src="' . esc_attr( $ribbon_path ) . 'service-' . esc_attr( $served_years ) . '.png" title="Service award, year ' . esc_attr( $served_years ) . '" width="350" height="94"></p>';
	}
}

$list_of_ribbons = get_field( 'operational_awards' );
if ( $list_of_ribbons ) {
	foreach ( $list_of_ribbons as $ribbon ) {
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ) . '.png" title="' . esc_attr( $ribbon['label'] ) . '" width="350" height="94"></p>';
	}
}

$list_of_ribbons = get_field( 'community_awards' );
if ( $list_of_ribbons ) {
	foreach ( $list_of_ribbons as $ribbon ) {
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ) . '.png" title="' . esc_attr( $ribbon['label'] ) . '" width="350" height="94"></p>';
	}
}
