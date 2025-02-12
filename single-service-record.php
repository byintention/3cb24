<?php get_header(); ?>
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
	( in_array( 'training_admin', wp_get_current_user()->roles)) || 
	( in_array( 'recruit_admin', wp_get_current_user()->roles)) || 
	( in_array( 'administrator', wp_get_current_user()->roles)) ) {
		?>	
	<?php
	if ( have_posts() ) :
		while (have_posts()) :
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
				$isAdmin = in_array( 'administrator', wp_get_current_user()->roles);
				$userId = get_field( 'user_id' );
				if ($userId != "") {
					$user = get_user_by( 'id', $userId );
				} else {
					$user = wp_get_current_user();
					$userId = $user->ID;
				}
				$displayName = $user->get( 'display_name' );
				$userProfile = 'user_' . $userId;
				$postIdField = 'post_id'; 
				$postId = get_field( $postIdField, $userProfile );
				?>
				<div class="tcb_user_info five columns">
					<h3>User info</h3>
					<?php
					// Rank
					$path = plugins_url() . '/tcb-roster/images/ranks/';
					$rank = get_field( 'rank', $postId );
					if ( !$rank )
						return $return;
					?>
					<p><img src="<?php echo $path . $rank['value']; ?>.gif" title="<?php echo $rank['label']; ?>" style="width:144px;height:240px;"></p>
					<table>
						<tr><td>Rank</td><td><?php echo $rank['label']; ?></td></tr>
					<?php
					// Location
					$location = get_field( 'user-location', $userProfile );
					if ($location) {
						?>
						<tr><td>Location</td><td><?php echo $location; ?></td></tr>
						<?php
					}
					// Steam ID
					$steamID = get_field( 'steam_id', $postId );
					if ($isAdmin && $steamID) {
						?>
						<tr><td>Steam ID</td><td><?php echo $steamID; ?></td></tr>
						<?php
					}
					// Discord ID
					$discordID = get_field( 'discord_id', $userProfile );
					if ($isAdmin && $discordID) {
						?>
						<tr><td>Discord ID</td><td><?php echo $discordID; ?></td></tr>
						<?php
					}
					// Email
					$email = $user->user_email;
					if ($isAdmin && $email) {
						?>
						<tr><td>Email</td><td><?php echo $email; ?></td></tr>
						<?php
					}
					// Dates
					if ( $rank['value'] == 'Rct' ) {
						$dateStr = get_field( 'attestation_date', $postId );
						$date = DateTime::createFromFormat( 'd/m/Y', $dateStr );
						if ($date) {
							$now = new DateTime('now');
							$interval = $date->diff( $now );
							?>
							<tr><td>Attestation</td><td><?php echo date_format($date, 'd-m-Y'); ?></td></tr>
							<tr><td>Length of recruit period: <?php echo $interval->format('%y year(s), %m month(s), %d day(s)'); ?></td></tr>
							<?php
						}
					} else {
						$dateStr = get_field( 'passing_out_date', $postId );
						$date = DateTime::createFromFormat( 'd/m/Y', $dateStr );
						if ($date) {
							$now = new DateTime('now');
							$interval = $date->diff( $now );
							?>
							<tr><td>Passing out</td><td><?php echo date_format( $date, 'd-m-Y' ); ?></td></tr>
							<tr><td>Length of service</td><td><?php echo $interval->format( '%y year(s), %m month(s), %d day(s)' ); ?></td></tr>
							<?php
						}
					}
					// LOA
					if ( (get_field( 'loa', $postId ) == 1 ) && ( $rank['value'] != "Res" ) ) { ?>
						<tr><td>Approved LOA</td></tr>
						<?php
					}
					?>
					</table>
					
					<div class="tcb_user_edit_options">
					<?php
					$roles = wp_get_current_user()->roles;
					if (in_array( 'training_admin', $roles)) {
						echo '<br><a href="'. home_url() .'/edit-training-record/?id=' . $userId . '" class="button button-secondary">Edit Training Record</a><br>';
					}
					if (in_array( 'commendation_admin', $roles)) {
						echo '<br><a href="'. home_url() .'/edit-ribbons/?id=' . $userId . '" class="button button-secondary">Edit Commendations</a><br>';
					}
					if (in_array( 'administrator', $roles)) {
						echo '<br><a href="'. home_url() .'/edit-service-record/?id=' . $userId . '" class="button button-secondary">Edit Service Record</a><br>';
					}
					?>
					</div>
				</div>
				<div class="tcb_user_training five columns">
					<?php
					// Duties
					$listOfDuties = get_field( 'duties', $postId );
					if ( $listOfDuties ) {
						?>
						<h3>Administrative duties</h3><ul>
						<?php
						foreach ( $listOfDuties as $duty ) { ?>
							<li><?php echo $duty['label']; ?></li>
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
								echo '<li>' . $course['label'] . '</li>';
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
					$path = plugins_url() . '/tcb-roster/images/ribbons/';
					$dateStr = get_field( 'passing_out_date' );
					$date = DateTime::createFromFormat('d/m/Y', $dateStr);
					if ($date) {
						$now = new DateTime('now');
						$interval = $date->diff($now);
						$served_years = $interval->y;
						if ($served_years > 0) { ?>
							<p><img src="<?php echo $path . 'service-' . $served_years;?>.png" title="Service award, year <?php echo  $served_years; ?>" width="350" height="94"></p>
						<?php
						}
					}
					$list_of_ribbons = get_field( 'operational_awards' );
					if ( $list_of_ribbons ) {
						foreach ( $list_of_ribbons as $ribbon ) { ?>
							<p><img src="<?php echo $path . $ribbon['value']; ?>.png" title="<?php echo $ribbon['label']; ?>" width="350" height="94"></p>
						<?php
						}
					}
					$list_of_ribbons = get_field( 'community_awards' );
					if ( $list_of_ribbons ) {
						foreach ( $list_of_ribbons as $ribbon ) { ?>
							<p><img src="<?php echo $path . $ribbon['value']; ?>.png" title="<?php echo $ribbon['label']; ?>" width="350" height="94"></p>
						<?php
						}
					}
					?>
				</div>
			</div>
			</div>
		</div>
			<?php
			comments_template();
			?>
		<?php 
			endwhile;
		endif;
		?>
	</div>
<?php
} else {
	echo '<p class="negative">Not authorised</p>';
}
?>
</div>
<?php get_footer(); ?>