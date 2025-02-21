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
				<h2>Candidate phase</h2>
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
					'type'   => 'Interview',
					'status' => 'Pending',
					'info'   => 'Being processed and interviewed',
				);
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Approved';
				$args['info']   = 'Candidate phase: basic training, trial operation (with buddy), awaiting decision on attestation';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Rejected';
				$args['info']   = 'Candidate phase unsuccessful, rejected';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
		<div class="post white" id="post-<?php the_ID(); ?>" >
			<div class="entry padded">
				<?php
				$args['status'] = 'Archived';
				$args['info']   = 'Candidate phase successful, progressed to Recruit';
				get_template_part( 'includes/archive-post', null, $args );
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
