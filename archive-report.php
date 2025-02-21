<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * LOA archive, used to display a list of LOAs.
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
				<h1>Reports</h1>
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
					'role'   => array( 'training_admin', 'recruit_admin', 'administrator' ),
					'type'   => 'Report',
					'status' => 'Pending',
					'info'   => 'Yet to be processed',
				);
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Approved';
				$args['info']   = 'Report under investigation, awaiting decision or action';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Rejected';
				$args['info']   = 'Report rejected';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Archived';
				$args['info']   = 'Report concluded';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
