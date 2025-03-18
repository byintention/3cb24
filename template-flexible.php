<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
	Template Name: Flexible content Page

	@package 3cb24
 */

acf_form_head();
get_header(); ?>
	<div class="wrap clear">
		<div id="content">
			<div class="container textPage">
				<div class="twelve columns">
				<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						the_content();
					}
				}
				?>
				</div>
			</div>
		</div>
		
		<div id="success-message" style="display:none;"></div>
	<?php get_template_part( 'includes/flexible-content' ); ?>
	</div>
<?php get_footer(); ?>