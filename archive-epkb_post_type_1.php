<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Wiki homepage for 3cb24 theme
 *
 * @package tcb24
 */

get_header(); ?>
<div id="tcbWiki">
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
		<?php
			$wikiterms = get_terms(
				array(
					'taxonomy' => 'epkb_post_type_1_category',
					'order'    => 'asc',
					'orderby'  => 'name',
					'parent'   => 0,
				)
			);
			if ( ! empty( $wikiterms ) && ! is_wp_error( $wikiterms ) ) {
				foreach ( $wikiterms as $wikiterm ) {
					?>
					<div class="wiki-category four columns padded white">
						
						<h3><?php echo esc_html( $wikiterm->name ); ?></h3>
						<?php
						// var_dump($wikiterm);
						// Get subcategories in this category.
						$sub_cats = get_terms(
							array(
								'taxonomy' => 'epkb_post_type_1_category',
								'order'    => 'asc',
								'orderby'  => 'name',
								'parent'   => $wikiterm->term_id,
							),
						);

						// Build array of cats to exclude from top level list.
						$categories_to_exclude = array();
						foreach ( $sub_cats as $sub_cat ) {
							$categories_to_exclude[] = $sub_cat->term_id;
						}
						$excludes = implode( ', ', $categories_to_exclude );

						// Show only posts in this category - not sub categories.
						$args = array(
							'post_type'      => 'epkb_post_type_1',
							'posts_per_page' => 120,
						);

						$query = new WP_Query( $args );
						?>
						<ul class="wiki-docs">
						<?php
						while ( $query->have_posts() ) {
							$query->the_post();

							$term_list = wp_get_post_terms( $query->post->ID, 'epkb_post_type_1_category', array( 'fields' => 'ids' ) );

							if ( in_array( $wikiterm->term_id, $term_list, true ) ) {
								?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php
							}
						}
						wp_reset_postdata();
						?>
						</ul>
						<!-- Sub categories -->
						<?php
						if ( ! empty( $sub_cats ) && ! is_wp_error( $sub_cats ) ) {
							?>
							<ul class="wiki-subcats">
							<?php foreach ( $sub_cats as $sub_cat ) { ?>
								<li><a href="<?php echo esc_html( get_term_link( $sub_cat ) ); ?>"><?php echo esc_html( $sub_cat->name ); ?></a></li>
								<?php
							}
							?>
							</ul>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
			?>
	</div>
</div>
<?php get_footer(); ?>