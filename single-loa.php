<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar.
/**
 * Single LOA template, used to display a single LOA.
 *
 * @package 3cb24
 */
get_header();
?>

<div class="blogBanner banners">
	<?php
	$page_for_posts = get_option( 'page_for_posts' );
	echo get_the_post_thumbnail( $page_for_posts, 'large' );
	?>
	<div class="inner">
		<div class="container">
			<div class="twelve columns centre">
				<h1>LOA: <?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="twelve columns">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="post white" id="post-<?php the_ID(); ?>">
					<div class="padded">
					<?php
					if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
						seopress_display_breadcrumbs();
					}
					?>
					</div>

					<div class="entry padded">
					<?php
					$args = array(
						'role' => array( 'training_admin', 'recruit_admin', 'administrator' ),
					);
					get_template_part( 'includes/content', null, $args );
					?>
					</div>

					<div>
					<?php
					$args = array(
						'role'        => array( 'training_admin', 'recruit_admin', 'administrator' ),
						'duration'    => '',
						'comment_php' => '/comments.php',
					);
					get_template_part( 'includes/conditional-comments', null, $args );
					?>
					</div>
				</div>
				<?php
			endwhile;
		endif;
		?>
	</div>
</div>
<?php get_footer(); ?>
