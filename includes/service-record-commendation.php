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
		echo '<p>';
		tcbp_public_commendation_image( $ribbon_path . 'service-' . $served_years . '.png', 'Service award, year ' . $served_years, '', 350, 94 );
		echo '</p>';
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
 * tcbp_public_commendation_image() helper (defined in the tcb-roster plugin).
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
		echo '<p>';
		tcbp_public_commendation_image( $ribbon_path . $ribbon['value'] . '.png', $ribbon['label'], $ribbon['value'], 350, 94 );
		echo '</p>';
	}
}

/**
 * Renders a "level"-type commendation group (Leadership/Mention in Despatches/Mission Creation)
 * for the current user - each sub-field holds a count, shown once it's > 0. Display name, order,
 * and tooltip description all come from the matching taxonomy child term (looked up by
 * slug = sub-field name), via the shared tcbp_public_commendation_group_terms() and
 * tcbp_public_commendation_image() helpers (defined in the tcb-roster plugin).
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

	$children = tcbp_public_commendation_group_terms( $group_slug );
	if ( ! $children ) {
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
			$parent = get_term( $term->parent, 'tcb-commendation' );
			echo '<h4>' . esc_html( $parent && ! is_wp_error( $parent ) ? $parent->name : '' ) . '</h4>';
			$print_header = true;
		}

		foreach ( $image_translation as $idx => $img_val ) {
			if ( $img_val > $value ) {
				break;
			}
		}

		// Title shows the 1-5 level as a Roman numeral (tcbp_public_commendation_award_level()/
		// tcbp_public_commendation_award_level_roman(), commendations.php - the same level
		// calculation the commendations archive page uses), not $idx above, which is a separate,
		// differently-indexed value used only to pick which ribbon image file to show.
		$level = tcbp_public_commendation_award_level( $value );
		$title = $term->name . ' - ' . tcbp_public_commendation_award_level_roman( $level );

		echo '<p>';
		tcbp_public_commendation_image( $ribbon_path . $term->slug . '-' . $idx . '.png', $title, $term->slug, 350, 94, '<b>Awards: ' . $value . '</b>' );
		echo '</p>';
	}
}
