<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		?>
	<div class="post white" id="post-<?php the_ID(); ?>" >
		<?php
		if ( has_post_thumbnail() ) {
			?>
		<div class="news-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<img loading="lazy" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>">
			</a>
		</div>
			<?php
		}
		?>
		<div class="padded">
			<h3 class="blog-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
			<?php the_excerpt(); ?>
			<hr>
			<p class="postmetadata clear">
				<span class="blogcat">Posted in <?php the_category( ', ' ); ?></span> &bull; 
				<span class="blogdate"><?php the_time( 'F jS, Y' ); ?></span>
			</p>
		</div>
	</div>
		<?php
	}
	?>
	<div class="navigation">
		<div class="navlink"><?php next_posts_link(); ?></div>
		<div class="navlink"><?php previous_posts_link(); ?></div>
	</div>
	<?php
} else {
	?>
	<h2 class="center">Not Found</h2>  
	<p class="center">Sorry, but you are looking for something that isn't here.</p>
	<?php
	get_search_form();
}
?>
