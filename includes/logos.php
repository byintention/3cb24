<section id="panel<?php echo esc_attr( $counter ); ?>" class="logos bg-lightgrey">
	<div class="container" style="max-width: <?php the_sub_field( 'max_width' ); ?>px;">
		<?php
		if ( have_rows( 'logos' ) ) {
			?>
		<div class="logos">
			<div class="slidesLogos">
			<?php
			while ( have_rows( 'logos' ) ) {
				the_row();
				?>
				<div class="logo">
					<img loading="lazy" src="<?php the_sub_field( 'image' ); ?>" alt="<?php the_sub_field( 'alt_text' ); ?>">
				</div>
				<?php
			}
			?>
			</div>
		</div>
			<?php
		}
		?>
	</div>
</section>