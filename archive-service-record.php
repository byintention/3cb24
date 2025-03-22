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
				<h1>Roster</h1>
				<h2>Service Records</h2>
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
					'role' => array( 'member', 'limited_member', 'administrator' ),
					'rank' => 'Officer',
				);
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Colour Sergeant';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Sergeant';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Corporal';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Lance Corporal';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Marine';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Recruit';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['rank'] = 'Reserve';
				get_template_part( 'includes/archive-service-record', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<p>The full range of <a href="/hidden/duties">Administrative Duties</a> can be found here.<br>
			</div>
		</div>
	</div>
</div>
<?php
get_footer(); ?>
