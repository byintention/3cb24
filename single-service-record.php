<?php
/**
 * Single service record template for 3cb24 theme
 *
 * @package tcb24
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
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<div class="post white serviceRecord" id="post-<?php the_ID(); ?>">
				<div class="padded" style="padding-bottom:0;">
					<?php
					if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
						seopress_display_breadcrumbs();
					}
					?>
				</div>
				<div class="entry padded">
					<div class="container">
						<div class="tcb_user_info four columns">
							<?php
							$args = array(
								'role' => array( 'member', 'administrator' ),
							);
							get_template_part( 'includes/service-record', null, $args );
							?>
						</div>
						<div class="tcb_user_training five columns">
						<?php
							$args = array(
								'role' => array( 'member', 'administrator' ),
							);
							get_template_part( 'includes/service-record-training', null, $args );
							?>
						</div>
						<div class="tcb_user_ribbons three columns">
						<?php
							$args = array(
								'role' => array( 'member', 'administrator' ),
							);
							get_template_part( 'includes/service-record-commendation', null, $args );
							?>
						</div>
					</div>
					<div>
					<?php
						$args = array(
							'role'        => array( 'officer', 'administrator' ),
							'duration'    => '',
							'comment_php' => '/comments-service-record.php',
						);
						get_template_part( 'includes/conditional-comments', null, $args );
						?>
					</div>
				</div>
			</div>
			<?php
		endwhile;
	endif;
	?>
</div>
<?php get_footer(); ?>