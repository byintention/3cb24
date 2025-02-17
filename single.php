<?php
/**
	Single news post template for 3cb24 theme

	@package tcb24
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
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="eight columns">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
		<div class="post white" id="post-<?php the_ID(); ?>">
			<?php
			if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
				seopress_display_breadcrumbs();
			}
			?>
			<?php
			if ( has_post_thumbnail() ) {
				?>
			<div class="news-thumb">
				<img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>">
			</div>
				<?php
			}
			?>
			<div class="entry padded">
				<?php the_content(); ?>
				<p class="postmetadata clear">
					<span class="blogcat">Posted in <?php the_category( ', ' ); ?></span><span class="blogdate">
					<?php the_time( 'F jS, Y' ); ?> </span>
				</p>
			</div>
		</div>
			<?php
		endwhile;
	endif;
	?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>