<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Application archive, used to display a list of applications.
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
				<h1>Recruit phase</h1>
				<h2>Applications</h2>
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
					'role'   => array( 'training_admin', 'recruit_admin', 'officer', 'snco', 'nco', 'administrator' ),
					'type'   => 'Application',
					'status' => 'Pending',
					'info'   => 'Being processed or in Candidate phase',
				);
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Approved';
				$args['info']   = 'Recruit phase: awaiting decision on passing out';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Rejected';
				$args['info']   = 'Recruit (or Candidate) phase unsuccessful, rejected';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Archived';
				$args['info']   = 'Recruit phase successful, progressed to Marine';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
