<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * The 404 error page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package 3cb24
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
				<h1>Search Results</h1>
			</div>
		</div>
	</div>
</div>
<div class="container searchResults">
	<div class="twelve columns">
	<?php get_template_part( 'includes/postloop' ); ?>
	</div>
</div>
<?php get_footer(); ?>
