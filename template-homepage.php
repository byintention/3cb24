<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Template for homepage
 *
 * @package tcb24
 */
?>

<?php get_header(); ?>

<div id="content" class="clear clearfix">
	<div id="home-content" class="twelve columns clearfix">
		<?php
		// Display the page content / body.
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?>
	</div>
	
	<div id="home-news" class="twelve columns">
		<div class="row">
			<?php
			$home_query = new WP_Query( 'showposts=3' );
			if ( $home_query->have_posts() ) :
				while ( $home_query->have_posts() ) :
					$home_query->the_post();
					?>
			
				<div class="news-item clearfix four columns">
					<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>
						<div class="newsthumb">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail( 'medium' ); ?>
							</a>
						</div>
					<?php } ?>
						
					<h4><?php the_title(); ?></h4>
					
					<p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read more &raquo;</a></p>
					
					<div class="clear"></div>
				</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<p><a href="/news-and-blog/" class="button">Read all news &raquo;</a></p>
	</div>
</div>

<?php get_footer(); ?>
