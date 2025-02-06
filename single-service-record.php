<?php get_header(); ?>
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
	<div class="twelve columns">
    <?php if ( have_posts() ) :
		while (have_posts()) :
			the_post();
				?>
		<div class="post white" id="post-<?php the_ID(); ?>">
			<div class="padded">
				<?php if( function_exists( "seopress_display_breadcrumbs" ) ) {
					seopress_display_breadcrumbs();
				} ?>
			</div>

			<div class="entry padded">
				<h3>Rank</h3>
				<?php the_field( 'rank' ); ?>
				
				<h3>Duties</h3>
				<?php print_r ( the_field( 'duties' ) ); ?>
				
				<h3>Training</h3>
				
				<?php the_field( 'courses_completed' ); ?>
				
			</div>
			<?php
			comments_template();
			?>
		</div>
		<?php 
		endwhile;
	endif; ?>
	</div>
	<?php //get_sidebar(); ?> 
</div>
<?php get_footer(); ?> 