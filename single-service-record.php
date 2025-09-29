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
				<?php
				$user_id_badger = get_field( 'user_id' );
				$user_info = get_userdata( $user_id_badger);
				$display_name = $user_info->display_name;
				?>
				<h1><?php echo $display_name; ?></h1>
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
				<div class="padded" style="padding-bottom: 0;">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
							<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemscope="" itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?php echo esc_url( home_url() ); ?>" href="<?php echo esc_url( home_url() ); ?>"><span itemprop="name">Home</span></a><meta itemprop="position" content="1"></li>
							<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a itemscope="" itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?php echo esc_url( home_url() ); ?>/service-record-archive/" href="<?php echo esc_url( home_url() ); ?>/service-record-archive/"><span itemprop="name">Service Records</span></a><meta itemprop="position" content="2"></li>
							<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><span itemprop="name"><?php echo $display_name; ?>’s Service Record</span><meta itemprop="position" content="3"></li>
						</ol>
					</nav>
				</div>
				<div class="entry padded">
					<div class="container">
						<div class="tcb_user_info four columns">
							<?php
							$args = array(
								'role' => array( 'limited_member', 'member', 'administrator' ),
							);
							get_template_part( 'includes/service-record', null, $args );
							?>
						</div>
						<div class="tcb_user_training five columns">
						<?php
							$args = array(
								'role' => array( 'limited_member', 'member', 'administrator' ),
							);
							get_template_part( 'includes/service-record-training', null, $args );
							?>
						</div>
						<div class="tcb_user_ribbons three columns">
						<?php
							$args = array(
								'role' => array( 'limited_member', 'member', 'administrator' ),
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
