<?php
	$format_in = 'Y-m-d'; // the format your value is saved in (set in the field options)
	$format_out = 'F j, Y'; // the format you want to end up with
	$date = DateTime::createFromFormat( $format_in, get_field( 'event_start_date') );	
?>
<article class="intention-events-listing-event">
	<a href="<?php the_permalink(); ?>">
	<?php
	if ( has_post_thumbnail() ) { ?>
		<div class="intention-events-listing-image">
			<a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail( 'full' ); ?>
			</a>
		</div>
	<?php } ?>
	<div class="intention-events-listing-title centre">
		<h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
		<p><?php echo $date->format( $format_out ); ?> | <?php the_field( 'event_start_time' ); ?> - <?php the_field( 'event_end_time' ); ?></p>
	</div>
	</a>
</article>