<?php
/**
 * Wiki single article template for 3cb24 theme
 *
 * @package tcb24
 */

get_header(); ?>
<div id="tcbWikiSingle">
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
		<div class="nine columns">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				?>
			<div class="post white padded" id="post-<?php the_ID(); ?>">
				<div class="bread has-small-font-size">
				<?php
				if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
					seopress_display_breadcrumbs();
				}
				?>
				</div>
				<div class="entry">
					<h1 id="h1"><?php the_title(); ?></h1>
					<p class="postMetadata clear has-small-font-size">
						<span class="blogAuthor">Posted by <strong><?php the_author(); ?></strong></span> &nbsp; 
						<span class="blogDate">Last updated <?php the_modified_time( 'F jS, Y' ); ?> </span>
					</p>
					<?php the_content(); ?>
					
					<!-- TO DO - prev/next or related articles -->
					
				</div>
			</div>
				<?php
			}
		}
		?>
		</div>
		<div class="three columns">
			<div id="toc" class="padded white">
				<h4>Table of Contents</h4>
				<a href="#h1">Title</a>
				<ul id="toclist"></ul>
			</div>
			<script>
				function generateTOC() {
					const container = document.querySelector(".entry");
					const headings = container.querySelectorAll( "h2, h3, h4, h5, h6" );
					toc_html = "";
					headings.forEach( (heading, index, array) => {
						// Get current heading level
						var headerlevel = heading.outerHTML.charAt(2);
						// Add the ID to the header tag
						heading.id = "heading-" + index;
						// See if we've got a following header tag, get the level if so
						if ( index < ( array.length -1 ) ) { 
							var nextheadingtag = array[index+1];
							var nextlevel = nextheadingtag.outerHTML.charAt(2);
						} else {
							var nextlevel = 0;
						}	
						// Close submenu if next header is smaller number
						if ( nextlevel < headerlevel ) {
							toc_html += '<li><a href="#' + heading.id + '">' + heading.textContent + '</a></li>';
							toc_html += '</ul></li></ul>';
						}
						// Create submenu if next header is bigger number
						if ( nextlevel > headerlevel ) {
							toc_html += '<li><a href="#' + heading.id + '">' + heading.textContent + '</a>';
							toc_html += '<ul class="nest">';
						}
						// No submenu open/close if next header is same level 
						if ( nextlevel == headerlevel ) {
							toc_html += '<li><a href="#' + heading.id + '">' + heading.textContent + '</a></li>';
						}
					});
					document.getElementById('toclist').innerHTML += toc_html;
				}
				// Call the function when the document is ready
				window.addEventListener("DOMContentLoaded", generateTOC); 
			</script>
		</div>
	</div>
</div>
<?php get_footer(); ?>