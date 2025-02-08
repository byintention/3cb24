<?php
/**
 * Default page template for 3cb24 theme
 *
 * @package 3cb24
 */

acf_form_head();
get_header(); ?>
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
			
			comments_template();
			?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>