<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Interview archive, used to display a list of interviews.
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
				<h1>Interviews</h1>
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
					'role'          => array( 'training_admin', 'recruit_admin', 'administrator' ),
					'type'          => 'Interview',
					'display_field' => 'applicant',
					'status'        => 'Pending',
				);
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Approved';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Rejected';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Archived';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
