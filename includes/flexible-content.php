<?php // phpcs:ignore Generic.Files.LineEndings.InvalidEOLChar
/**
 * Advanced Custom Fields Pro - Flexible Content Rows
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package 3cb24
 */

if ( have_rows( 'flexible_content' ) ) {
	$field_object = get_field_object( 'flexible_content' );
	$total_rows   = count( $field_object['value'] );
	$counter      = 0;
	while ( have_rows( 'flexible_content' ) ) {
		the_row();
		++$counter;

		if ( get_row_layout() === 'full' ) {
			?>
		<section class="full clearfix">
			<div class="text">
				<?php the_sub_field( 'content' ); ?>
			</div>
		</section>
			<?php



		} elseif ( get_row_layout() === 'filler' ) {
			?>
			<div id="panel<?php echo esc_attr( $counter ); ?>" class="filler <?php the_sub_field( 'background' ); ?>"></div>
			<?php


		} elseif ( get_row_layout() === 'banner_block' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="banners clear">
			<picture>
				<source media="(max-width:599px)" srcset="<?php the_sub_field( 'mobile_banner' ); ?>">
				<source media="(min-width:600px)" srcset="<?php the_sub_field( 'desktop_banner' ); ?>">
				<img src="<?php the_sub_field( 'mobile_banner' ); ?>" alt="<?php the_title(); ?>">
			</picture>
				<div class="inner">
					<div class="container">
						<div class="twelve columns">
							<?php the_sub_field( 'banner_text' ); ?>
						</div>
					</div>
				</div>
		</section>
			<?php


		} elseif ( get_row_layout() === 'filler' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="filler"></section>
			<?php
		} elseif ( get_row_layout() === 'testimonial' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="testimonials">
			<div class="container">
				<div class="slides">
				<?php
				if ( have_rows( 'testimonials' ) ) {
					while ( have_rows( 'testimonials' ) ) {
						the_row();
						?>
						<div class="testimonial">
							<blockquote>
								<?php the_sub_field( 'testimonial_text' ); ?>
								<cite>
									<?php the_sub_field( 'testimonial_name' ); ?>
								</cite>
							</blockquote>
						</div>
						<?php
					}
				} else {
					?>
					<p class="negative">Please add some testimonials!</p>
					<?php
				}
				?>
				</div>
			</div>
		</section>
			<?php

		} elseif ( get_row_layout() === 'faq' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="faqs">
			<div class="container">
				<div class="twelve columns">
				<?php
				if ( have_rows( 'faqs' ) ) {
					while ( have_rows( 'faqs' ) ) {
						the_row();
						?>
				<div class="faq">	
					<h2 class="faq-question"><?php the_sub_field( 'faq_question' ); ?></h2>	
					<div class="faq-answer">
						<?php the_sub_field( 'faq_answer' ); ?>
					</div>
				</div>
						<?php
					}
				} else {
					?>
				<p class="negative">Please add some FAQs!</p>
					<?php
				}
				?>
				</div>
			</div>
		</section>
			<?php

		} elseif ( get_row_layout() === 'boxes' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="boxes <?php the_sub_field( 'classes' ); ?> <?php the_sub_field( 'background' ); ?>">
			<div class="container grid <?php the_sub_field( 'vertical_align' ); ?>">
				<?php
				if ( have_rows( 'boxes' ) ) {
					while ( have_rows( 'boxes' ) ) {
						the_row();
						?>
					<div class="box <?php the_sub_field( 'class' ); ?>">
						<?php the_sub_field( 'content' ); ?>
					</div>
						<?php
					}
				} else {
					?>
				<p class="negative">Please add some boxes!</p>
					<?php
				}
				?>
			</div>
		</section>
			<?php

		} elseif ( get_row_layout() === 'text_and_image_block' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="text-and-image clear clearfix" style="background-image:url(<?php the_sub_field( 'text_and_image_block_image' ); ?>);">
			<div class="container">
				<div class="text-block <?php the_sub_field( 'textbox_location' ); ?>">
					<?php the_sub_field( 'text_and_image_block_content' ); ?>
				</div>	
			</div>
		</section>
			<?php

		} elseif ( get_row_layout() === 'gallery' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="clearfix gallery" >
			<div class="container mygallery" itemscope itemtype="http://schema.org/ImageGallery">
				<?php
				$images = get_sub_field( 'images' );
				if ( $images ) {
					foreach ( $images as $image ) {
						?>
				<figure itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject" class="galleryImage">
					<a href="<?php echo esc_url( $image['sizes']['large'] ); ?>" itemprop="contentUrl" data-pswp-width="<?php echo esc_attr( $image['width'] ); ?>" data-pswp-height="<?php echo esc_attr( $image['height'] ); ?>" data-cropped="true" >
						<img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" itemprop="thumbnail" alt="<?php echo esc_attr( $image['alt'] ); ?>">
						<div class="overlay">
							<svg version="1.1" id="Magnifying_glass" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><path fill="#ffffff" d="M17.545,15.467l-3.779-3.779c0.57-0.935,0.898-2.035,0.898-3.21c0-3.417-2.961-6.377-6.378-6.377 C4.869,2.1,2.1,4.87,2.1,8.287c0,3.416,2.961,6.377,6.377,6.377c1.137,0,2.2-0.309,3.115-0.844l3.799,3.801 c0.372,0.371,0.975,0.371,1.346,0l0.943-0.943C18.051,16.307,17.916,15.838,17.545,15.467z M4.004,8.287 c0-2.366,1.917-4.283,4.282-4.283c2.366,0,4.474,2.107,4.474,4.474c0,2.365-1.918,4.283-4.283,4.283 C6.111,12.76,4.004,10.652,4.004,8.287z"/></svg>
						</div>
					</a>
				</figure>
						<?php
					}
				}
				?>
				</div>
		</section>
			<?php
			// End Gallery Row.

		} elseif ( get_row_layout() === 'three_column' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="clearfix threeColumn">
			<div class="container">
				<div class="one-third column">
					<?php the_sub_field( 'content_left' ); ?>
				</div>
				<div class="one-third column">
					<?php the_sub_field( 'content_middle' ); ?>
				</div>
				<div class="one-third column">
					<?php the_sub_field( 'content_right' ); ?>
				</div>
			</div>
		</section>
			<?php


		} elseif ( get_row_layout() === 'two_column' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="clearfix twoColumn">
			<div class="container">
				<div class="one-half column">
					<?php the_sub_field( 'content_left' ); ?>
				</div>
				<div class="one-half column">
					<?php the_sub_field( 'content_right' ); ?>
				</div>
			</div>
		</section>
			<?php


		} elseif ( get_row_layout() === 'fifty_fifty' ) {
			?>
		<section id="panel<?php echo esc_attr( $counter ); ?>" class="clearfix fiftyFifty">
			<div class="container <?php echo ( get_sub_field( 'flip' ) ) ? 'flip' : ''; ?>">
				<div class="box text">
					<?php the_sub_field( 'content_left' ); ?>
				</div>
				<div class="box">
					<img src="<?php the_sub_field( 'image' ); ?>" alt="">
				</div>
				
			</div>
		</section>
			<?php
		}
	} // end while.
} else {
	?>
	<!-- no flex layouts -->
	<?php
} // end if.
?>
