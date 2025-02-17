<?php
/**
 * Blog index for 3cb24 theme
 *
 * @package 3cb24
 */

get_header(); ?>
<?php if ( is_home() ) { ?>
	<div class="blogBanner banners">
	<?php
		$page_for_posts = get_option( 'page_for_posts' );
		echo get_the_post_thumbnail( $page_for_posts, 'large' );
	?>
		<div class="inner">
			<div class="container">
				<div class="twelve columns centre">
					<h1><?php echo esc_html( get_the_title( $page_for_posts ) ); ?></h1>
				</div>
			</div>
		</div>
	</div> 
<?php } ?>
<div class="container">
	<div class="eight columns">
	<?php get_template_part( 'includes/postloop' ); ?>
	</div>
	<?php get_sidebar(); ?> 
</div>
<?php get_footer(); ?>