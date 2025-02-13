<?php get_header(); ?>
<div class="blogBanner banners">
	<?php
	$page_for_posts = get_option( 'page_for_posts' );
	echo get_the_post_thumbnail( $page_for_posts, 'large' );
	?>
	<div class="inner">
		<div class="container">
			<div class="twelve columns centre">
				<h1>Interview: <?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="twelve columns">

<?php
if (
	( in_array( 'training_admin', wp_get_current_user()->roles)) || 
	( in_array( 'recruit_admin', wp_get_current_user()->roles)) || 
	( in_array( 'administrator', wp_get_current_user()->roles)) ) {
		?>

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
				
				<?php
				
				$fields = get_field_objects($postID);
				
				if ($fields) {
					$userData = get_field( 'applicant' );
					echo '<ol>';

					foreach( $fields as $field ) {
						switch ($field['name']) {
							case 'applicant':
								echo '<li><strong>' . $field['label'] . ' </strong><br>' . $field['value']['display_name'] . '</li><br>';
								break;
							case 'interviewers':
								echo '<li><strong>' . $field['label'] . ' </strong><br>';
								$nameList = [];
								foreach( $field['value'] as $interviewer )
									$nameList[] = '<a href="' . add_query_arg( 'id', $interviewer['ID'], home_url() . '/user-info' ) . '">' . $interviewer['display_name'] . '</a>';
								echo implode(', ', $nameList) . '</li><br>';
								break;
							case 'Interview_evaluation':
								echo '<li><strong>' . $field['label'] . ' </strong><br>' . $field['value']['label'] . '</li><br>';
								break;
							default:
								if ($field['label'] == 'Status') {
									echo '<li><strong>' . $field['label'] . ' </strong><br>';
									$terms = get_the_terms( $postID, 'tcb-status' );
									if ($terms) {
										foreach($terms as $term) {
											echo $term->name;
										} 
									}
									echo '</li><br>';
								} else
									echo '<li><strong>' . $field['label'] . ' </strong><br>' . $field['value'] . '</li><br>';
						}
					}
					echo '</ol>';
			
				} ?>
				
				<p><a href="/edit-status/?id=<?php the_ID(); ?>" class="button button-secondary">Edit Status</a></p>

			</div>
			<?php
                $args = array( 'role' => array ('training_admin', 'recruit_admin', 'administrator'), 'duration' => 30 );
                get_template_part( 'includes/conditional-comments', null, $args );
			?>
		</div>
		<?php 
		endwhile;
	endif; ?>
	
<?php } else {
	echo '<p class="negative">Not authorised</p>';
}
	?>

	</div>
	<?php //get_sidebar(); ?> 
</div>
<?php get_footer(); ?> 