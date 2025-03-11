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
				<h1>Recruitment and Selection</h1>
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
		<?php
		$args = array(
			'role' => array( 'training_admin', 'recruit_admin', 'officer', 'snco', 'nco', 'administrator' ),
		);
		get_template_part( 'includes/archive-application', null, $args );
		?>
	</div>
</div>
<?php get_footer(); ?>
