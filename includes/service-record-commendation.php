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

$list_of_ribbons = get_field( 'campaign_medals' );
if ( $list_of_ribbons ) {
	echo '<h4>Campaign Medals</h4>';
	foreach ( $list_of_ribbons as $ribbon ) {
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ) . '.png" title="' . esc_attr( $ribbon['label'] ) . '" width="350" height="94"></p>';
	}
}

$image_translation = array( 1, 4, 16, 64, 256, 1024 );

$sub_field     = get_field( 'leadership' );
$section_title = 'Leadership Commendations';
if ( $sub_field ) {
	$print_header = false;
	$name         = 'troop';
	$title_       = 'Troop Leadership';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'section';
	$title_ = 'Section Leadership';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'fireteam';
	$title_ = 'Fireteam Leadership';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'asset';
	$title_ = 'Asset Leadership';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
}

$sub_field     = get_field( 'mention_in_despatches' );
$section_title = 'Mention in Despatches';
if ( $sub_field ) {
	$print_header = false;
	$name         = 'combat_medic';
	$title_       = 'Combat Medic';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'weapons_operator';
	$title_ = 'Weapons Operator';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'armour_asset';
	$title_ = 'Armour Asset';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'air_asset';
	$title_ = 'Air Asset';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'man_of_the_match';
	$title_ = 'Man of the Match';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
}

$sub_field     = get_field( 'mission_creation' );
$section_title = 'Mission Creation';
if ( $sub_field ) {
	$print_header = false;
	$name         = 'mission_author';
	$title_       = 'Mission Author';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
	$name   = 'zeus';
	$title_ = 'Zeus';
	if ( isset( $sub_field[ $name ] ) ) {
		$value = intval( $sub_field[ $name ] );
		if ( $value > 0 ) {
			if ( ! $print_header ) {
				echo '<h4>' . esc_attr( $section_title ) . '</h4>';
				$print_header = true;
			}
			foreach ( $image_translation as $idx => $img_val ) {
				if ( $img_val > $value ) {
					break;
				}
			}
			echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $name ) . '-' . esc_attr( $idx ) . '.png" title="' . esc_attr( $title_ ) . ' x' . esc_attr( $value ) . '" width="350" height="94"></p>';
		}
	}
}

$list_of_ribbons = get_field( 'community_awards' );
if ( $list_of_ribbons ) {
	echo '<h4>Community Awards</h4>';
	foreach ( $list_of_ribbons as $ribbon ) {
		echo '<p><img src="' . esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ) . '.png" title="' . esc_attr( $ribbon['label'] ) . '" width="350" height="94"></p>';
	}
}
