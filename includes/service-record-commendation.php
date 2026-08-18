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
		echo '<h4>Long Service Medal</h4>';
		echo '<p><img src="' . esc_attr( $ribbon_path ) . 'service-' . esc_attr( $served_years ) . '.png" title="Service award, year ' . esc_attr( $served_years ) . '" width="350" height="94"></p>';
	}
}

// Campaign Medals and Community Awards are simple multi-select fields - the field's own value
// list is exactly what the user has earned.
tcb24_service_record_commendation_select_group( 'campaign_medals', 'Campaign Medals', $ribbon_path );

$image_translation = array( 1, 4, 16, 64, 256, 1024 );

// Leadership/Mention in Despatches/Mission Creation are "level" fields - each sub-field holds a
// count. Display names, order, and descriptions all come from the matching tcb-commendation
// taxonomy group's child terms (looked up by slug = sub-field name), so a newly added sub-field
// (e.g. "patrol") is picked up automatically once a matching term exists - no code change
// needed here, unlike the previous hardcoded per-group lists.
tcb24_service_record_commendation_level_group( 'leadership', 'leadership_commendations', $ribbon_path, $image_translation );
tcb24_service_record_commendation_level_group( 'mention_in_despatches', 'mention_in_despatches', $ribbon_path, $image_translation );
tcb24_service_record_commendation_level_group( 'mission_creation', 'mission_creation', $ribbon_path, $image_translation );

tcb24_service_record_commendation_select_group( 'community_awards', 'Community Awards', $ribbon_path );

/**
 * Renders a "select"-type commendation group (Campaign Medals/Community Awards) for the current
 * user - the ACF field already returns exactly the choices they've earned. Tooltip text is the
 * choice's label plus (if set) the matching tcb-commendation term's description, via the shared
 * tcbp_public_commendation_tooltip() helper (defined in the tcb-roster plugin).
 *
 * @param string $field_name  The ACF field's name.
 * @param string $heading     The section heading.
 * @param string $ribbon_path Base URL for ribbon images.
 */
function tcb24_service_record_commendation_select_group( $field_name, $heading, $ribbon_path ) {
	$list_of_ribbons = get_field( $field_name );
	if ( ! $list_of_ribbons ) {
		return;
	}

	echo '<h4>' . esc_html( $heading ) . '</h4>';
	foreach ( $list_of_ribbons as $ribbon ) {
		$title = tcbp_public_commendation_tooltip( $ribbon['label'], $ribbon['value'] );
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ) . '.png" title="' . esc_attr( $title ) . '" width="350" height="94"></p>';
	}
}

/**
 * Renders a "level"-type commendation group (Leadership/Mention in Despatches/Mission Creation)
 * for the current user - each sub-field holds a count, shown once it's > 0. Display name, order,
 * and tooltip description all come from the matching taxonomy child term (looked up by
 * slug = sub-field name), via the shared tcbp_public_commendation_tooltip() helper.
 *
 * @param string $field_name        The ACF field's name (a group of int sub-fields).
 * @param string $group_slug        The taxonomy parent term's slug.
 * @param string $ribbon_path       Base URL for ribbon images.
 * @param array  $image_translation Level thresholds, lowest first.
 */
function tcb24_service_record_commendation_level_group( $field_name, $group_slug, $ribbon_path, $image_translation ) {
	$sub_field = get_field( $field_name );
	if ( ! $sub_field ) {
		return;
	}

	$parent = get_term_by( 'slug', $group_slug, 'tcb-commendation' );
	if ( ! $parent || is_wp_error( $parent ) ) {
		return;
	}

	$children = get_terms(
		array(
			'taxonomy'   => 'tcb-commendation',
			'parent'     => $parent->term_id,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);
	if ( ! $children || is_wp_error( $children ) ) {
		return;
	}

	$print_header = false;
	foreach ( $children as $term ) {
		if ( ! isset( $sub_field[ $term->slug ] ) ) {
			continue;
		}
		$value = intval( $sub_field[ $term->slug ] );
		if ( $value <= 0 ) {
			continue;
		}

		if ( ! $print_header ) {
			echo '<h4>' . esc_html( $parent->name ) . '</h4>';
			$print_header = true;
		}

		foreach ( $image_translation as $idx => $img_val ) {
			if ( $img_val > $value ) {
				break;
			}
		}

		$title = tcbp_public_commendation_tooltip( $term->name . ' x ' . $value, $term->slug );
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $term->slug ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title ) . '" width="350" height="94"></p>';
	}
}
