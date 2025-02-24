<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Blog archive for 3cb24 theme
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
				<h1>Service Records</h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="twelve columns">
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="padded">
				<?php
				if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
					seopress_display_breadcrumbs();
				}
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args = array(
					'role' => array( 'member', 'administrator' ),
					'rank' => 'Officer',
					'info' => 'The Officers are responsible for ensuring that 3CB continues to be a healthy engaging and exciting Arma 3 based community. They have full responsibility for the leadership and smooth running of the unit.',
				);
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Colour Sergeant';
				$args['info'] = 'In addition to the qualities mentioned for Sergeant, these members are placed within a position of responsibility and actively contribute to critical administrative duties – server, community, mission, and mod repo management/maintenance.';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Sergeant';
				$args['info'] = 'Long-serving members who continually demonstrate a positive attitude, maturity and a willingness to not only volunteer their leadership both in and out of game but to provide their valued feedback and input to the community. Coupled with the aforementioned, these members consistently show a willingness to volunteer their time and efforts in leading the various administrative duties of 3CB.';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Corporal';
				$args['info'] = 'Active members who continually demonstrate a positive attitude, maturity and a willingness to not only volunteer their leadership but to provide their valued feedback and input both in-game and within the community. These members also assist in the running of 3CB. e.g. frequently volunteer as Zeus, assist with training modding assistance, and PR/Media contributions.';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Lance Corporal';
				$args['info'] = 'Active members who continually demonstrate a positive attitude, maturity, and willingness to volunteer their leadership when needed.';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Marine';
				$args['info'] = '';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Recruit';
				$args['info'] = '';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Reserve';
				$args['info'] = '';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer(); ?>
