<?php
/**
	Template Name: Flexible content Page
		
	@package 3cb24
 */

?>
<?php acf_form_head(); ?>
<?php get_header(); ?>
	<div class="wrap clear">
	<?php get_template_part( 'includes/flexible-content' ); 
	
	comments_template();
	?>
	</div>
<?php get_footer(); ?>