<?php
/**
 * Single service record template for 3cb24 theme
 *
 * @package tcb24
 */

get_header(); ?>
<div class="blogBanner banners">
	<?php
	$page_for_posts = get_option( 'page_for_posts' );
	echo get_the_post_thumbnail( $page_for_posts, 'large' );
	?>
	<div class="inner">
		<div class="container">
			<div class="twelve columns centre">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</div>
<div class="container">

<?php
if (
	( in_array( 'training_admin', wp_get_current_user()->roles, true ) ) ||
	( in_array( 'recruit_admin', wp_get_current_user()->roles, true ) ) ||
	( in_array( 'administrator', wp_get_current_user()->roles, true ) ) ) {

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
		<div class="post white serviceRecord" id="post-<?php the_ID(); ?>">
			<div class="padded" style="padding-bottom:0;">
				<ul class="breadcrumb has-small-font-size">
					<li><a href="<?php echo esc_url( home_url() ); ?>">Home</a></li>
					<li><a href="<?php echo esc_url( home_url() ); ?>/roster/">Roster</a></li>
					<li><?php the_title(); ?></li>
				</ul>
			</div>
			<div class="entry padded">
				<div class="container">
				<?php
				$is_admin = in_array( 'administrator', wp_get_current_user()->roles, true );
				$user_id  = get_field( 'user_id' );
				if ( '' !== $user_id ) {
					$user = get_user_by( 'id', $user_id );
				} else {
					$user    = wp_get_current_user();
					$user_id = $user->ID;
				}
				$display_name    = $user->get( 'display_name' );
				$user_profile    = 'user_' . $user_id;
				$record_id_field = 'record_id';
				$record_id       = get_field( $record_id_field, $user_profile );
				?>
				<div class="tcb_user_info five columns">
					<h3>User info</h3>
					<?php
					// Rank.
					$rank_path = plugins_url() . '/tcb-roster/images/ranks/';
					$rank      = get_field( 'rank', $record_id );
					if ( ! $rank ) {
						return $return;
					}
					?>
					<p><img src="<?php echo esc_attr( $rank_path ) . esc_attr( $rank['value'] ); ?>.gif" title="<?php echo esc_attr( $rank['label'] ); ?>" width="144" height="240"></p>
					<table>
						<tr><td>Rank</td><td><?php echo esc_attr( $rank['label'] ); ?></td></tr>
					<?php
					// Location.
					$location = get_field( 'user-location', $user_profile );
					if ( $location ) {
						?>
						<tr><td>Location</td><td><?php echo esc_attr( $location ); ?></td></tr>
						<?php
					}
					// Steam ID.
					$steam_id = get_field( 'steam_id', $record_id );
					if ( $is_admin && $steam_id ) {
						?>
						<tr><td>Steam ID</td><td><?php echo esc_attr( $steam_id ); ?></td></tr>
						<?php
					}
					// Discord ID.
					$discord_id = get_field( 'discord_id', $user_profile );
					if ( $is_admin && $discord_id ) {
						?>
						<tr><td>Discord ID</td><td><?php echo esc_attr( $discord_id ); ?></td></tr>
						<?php
					}
					// Email.
					$email = $user->user_email;
					if ( $is_admin && $email ) {
						?>
						<tr><td>Email</td><td><?php echo esc_attr( $email ); ?></td></tr>
						<?php
					}
					// Dates.
					if ( 'Rct' === $rank['value'] ) {
						$date_str = get_field( 'attestation_date', $record_id );
						$date     = DateTime::createFromFormat( 'd/m/Y', $date_str );
						if ( $date ) {
							$now      = new DateTime( 'now' );
							$interval = $date->diff( $now );
							?>
							<tr><td>Attestation</td><td><?php echo esc_attr( date_format( $date, 'd-m-Y' ) ); ?></td></tr>
							<tr><td>Length of recruit period: <?php echo esc_attr( $interval->format( '%y year(s), %m month(s), %d day(s)' ) ); ?></td></tr>
							<?php
						}
					} else {
						$date_str = get_field( 'passing_out_date', $record_id );
						$date     = DateTime::createFromFormat( 'd/m/Y', $date_str );
						if ( $date ) {
							$now      = new DateTime( 'now' );
							$interval = $date->diff( $now );
							?>
							<tr><td>Passing out</td><td><?php echo esc_attr( date_format( $date, 'd-m-Y' ) ); ?></td></tr>
							<tr><td>Length of service</td><td><?php echo esc_attr( $interval->format( '%y year(s), %m month(s), %d day(s)' ) ); ?></td></tr>
							<?php
						}
					}
					// LOA.
					if ( ( 1 === get_field( 'loa', $record_id ) ) && ( 'Res' !== $rank['value'] ) ) {
						?>
						<tr><td>Approved LOA</td></tr>
						<?php
					}
					?>
					</table>
					
					<div class="tcb_user_edit_options">
					<?php
					$roles = wp_get_current_user()->roles;
					if ( in_array( 'training_admin', $roles, true ) ) {
						echo '<a href="' . esc_attr( home_url() ) . '/edit-training-record/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit Training Record</a>';
					}
					if ( in_array( 'commendation_admin', $roles, true ) ) {
						echo '<a href="' . esc_attr( home_url() ) . '/edit-ribbons/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit Commendations</a>';
					}
					if ( in_array( 'administrator', $roles, true ) ) {
						echo '<a href="' . esc_attr( home_url() ) . '/edit-service-record/?id=' . esc_attr( $user_id ) . '" class="button button-secondary">Edit Service Record</a>';
					}
					?>
					</div>
				</div>
				<div class="tcb_user_training five columns">
					<?php
					// Duties.
					$list_of_duties = get_field( 'duties', $record_id );
					if ( $list_of_duties ) {
						?>
						<h3>Administrative duties</h3><ul>
						<?php
						foreach ( $list_of_duties as $duty ) {
							?>
							<li><?php echo esc_attr( $duty['label'] ); ?></li>
							<?php
						}
						?>
						</ul>
						<?php
					}
					?>
					<h3>Training Completed</h3>
					<?php
					$list_of_courses = get_field( 'courses_completed' );
					if ( $list_of_courses ) {
						?>
						<ul>
							<?php
							foreach ( $list_of_courses as $course ) {
								echo '<li>' . esc_attr( $course['label'] ) . '</li>';
							}
							?>
						</ul>
						<?php
					}
					?>
				</div>
				
				<div class="tcb_user_ribbons two columns">
					<h3>Commendations</h3>
					<?php
					$ribbon_path = plugins_url() . '/tcb-roster/images/ribbons/';
					$date_str    = get_field( 'passing_out_date' );
					$date        = DateTime::createFromFormat( 'd/m/Y', $date_str );
					if ( $date ) {
						$now          = new DateTime( 'now' );
						$interval     = $date->diff( $now );
						$served_years = $interval->y;
						if ( $served_years > 0 ) {
							?>
							<p><img src="<?php echo esc_attr( $ribbon_path ) . 'service-' . esc_attr( $served_years ); ?>.png" title="Service award, year <?php echo esc_attr( $served_years ); ?>" width="350" height="94"></p>
							<?php
						}
					}
					?>
					<!-- Operational awards -->
					<?php
					$list_of_ribbons = get_field( 'operational_awards' );
					if ( $list_of_ribbons ) {
						foreach ( $list_of_ribbons as $ribbon ) {
							?>
							<p><img src="<?php echo esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ); ?>.png" title="<?php echo esc_attr( $ribbon['label'] ); ?>" width="350" height="94"></p>
							<?php
						}
					}
					?>
					<!-- Community awards -->
					<?php
					$list_of_ribbons = get_field( 'community_awards' );
					if ( $list_of_ribbons ) {
						foreach ( $list_of_ribbons as $ribbon ) {
							?>
							<p><img src="<?php echo esc_attr( $ribbon_path ) . esc_attr( $ribbon['value'] ); ?>.png" title="<?php echo esc_attr( $ribbon['label'] ); ?>" width="350" height="94"></p>
							<?php
						}
					}
					?>
				</div>
			</div>
			</div>
		</div>
			<?php
				$args = array(
					'role'        => array( 'officer', 'administrator' ),
					'duration'    => '',
					'comment_php' => '/comments-service-record.php',
				);
				get_template_part( 'includes/conditional-comments', null, $args );
				?>
			<?php
			endwhile;
		endif;
	?>
	</div>
	<?php
} else {
	echo '<div class="twelve columns" style="padding: 50px 0;"><p class="negative">Not authorised</p></div>';
}
?>
</div>
<?php get_footer(); ?>
