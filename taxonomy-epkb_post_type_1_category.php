<?php
/**
 * Wiki category archive for 3cb24 theme
 *
 * @package tcb24
 */

get_header(); ?>
<div id="tcbWikiListing">
	<div class="blogBanner banners">
	<?php
		$page_for_posts = get_option( 'page_for_posts' );
		echo get_the_post_thumbnail( $page_for_posts, 'large' );
	?>
		<div class="inner">
			<div class="container">
				<div class="twelve columns centre">
					<h1>Information Centre</h1>
					<div id="wikiSearch"><?php get_search_form(); ?></div>
				</div>
			</div>
		</div>
	</div>
	<div id="tcbWikiContent" class="container">
		<div class="tcbWikiArticles padded white">
			<div class="bread has-small-font-size">
			<?php
			if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
				seopress_display_breadcrumbs();
			}
			?>
			</div>
			<h2><?php single_cat_title(); ?></h2>
			<?php
			// Get current category.
			$current_cat = get_queried_object_id();
			echo '<p style="display:none;">Current category id: ' . esc_attr( $current_cat ) . '</p>';
			?>
			<ul class="wiki-docs">
			<?php
			// Show only posts in this category - not posts from sub categories.
			$args  = array(
				'post_type'      => 'epkb_post_type_1',
				'posts_per_page' => 110,
				'fields'         => 'ids, title, link',
			);
			$query = new WP_Query( $args );
			while ( $query->have_posts() ) {
				$query->the_post();
				$catterms = wp_get_post_terms( $query->post->ID, 'epkb_post_type_1_category' );
				if ( ! empty( $catterms ) ) {
					foreach ( $catterms as $catterm ) {
						if ( $current_cat === $catterm->term_id ) {
							?>
							<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
							<?php
						}
					}	
				}
			}
			wp_reset_postdata();
			?>
			</ul>
			<?php
			// Get subcategories in this category.
			$sub_cats = get_terms(
				array(
					'taxonomy' => 'epkb_post_type_1_category',
					'order'    => 'asc',
					'orderby'  => 'name',
					'parent'   => $current_cat,
				),
			);
			// Build array of cats to exclude from top level list, if we ever want more subcats
			// $categories_to_exclude = array();
			// foreach ( $sub_cats as $sub_cat ) {
			//	$categories_to_exclude[] = $sub_cat->term_id;
			// }
			// $excludes = implode( ', ', $categories_to_exclude );
			if ( ! empty( $sub_cats ) ) {
				?>
				<ul class="wiki-subcats">
				<?php
				foreach ( $sub_cats as $sub_cat ) {
					?>
					<li><a href="<?php echo esc_html( get_term_link( $sub_cat ) ); ?>"><?php echo esc_html( $sub_cat->name ); ?></a></li>
					<?php
				}
				?>
				</ul>
				<?php
			}
			?>
	</div>
</div>
<?php get_footer(); ?>