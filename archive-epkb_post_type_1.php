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

			// Fetched once, up front, and filtered per category below in PHP - rather than
			// re-querying per category - since posts_per_page has to stay unlimited (-1), not a
			// fixed cap: a cap here silently drops the oldest articles site-wide, in every
			// category at once, once the wiki's total article count grows past it (WP_Query's
			// default order is newest-first by post_date) - same bug already hit and fixed for
			// taxonomy-epkb_post_type_1_category.php but never carried over to this sibling
			// template. Running that unbounded query once per top-level category, as this
			// previously did, would otherwise turn one full-table scan into N of them.
			$wiki_articles = get_posts(
				array(
					'post_type'      => 'epkb_post_type_1',
					'posts_per_page' => -1,
				)
			);

			if ( ! empty( $wikiterms ) && ! is_wp_error( $wikiterms ) ) {
				foreach ( $wikiterms as $wikiterm ) {
					// Don't show a category link the user has no access to.
					if ( tcb24_wiki_is_category_restricted_for_user( $wikiterm->term_id ) ) {
						continue;
					}
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
						// Don't link to subcategories the user has no access to either.
						$sub_cats = array_filter(
							$sub_cats,
							function ( $sub_cat ) {
								return ! tcb24_wiki_is_category_restricted_for_user( $sub_cat->term_id );
							}
						);

						// Build array of cats to exclude from top level list.
						$categories_to_exclude = array();
						foreach ( $sub_cats as $sub_cat ) {
							$categories_to_exclude[] = $sub_cat->term_id;
						}
						$excludes = implode( ', ', $categories_to_exclude );

						// Show only posts in this category - not sub categories - matched against
						// the shared $wiki_articles fetched once above.
						?>
						<ul class="wiki-docs">
						<?php
						foreach ( $wiki_articles as $wiki_article ) {

							$term_list = wp_get_post_terms( $wiki_article->ID, 'epkb_post_type_1_category', array( 'fields' => 'ids' ) );

							if ( in_array( $wikiterm->term_id, $term_list, true ) ) {
								?>
								<li><a href="<?php echo esc_url( get_permalink( $wiki_article ) ); ?>"><?php echo esc_html( get_the_title( $wiki_article ) ); ?></a></li>
								<?php
							}
						}
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