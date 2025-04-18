<?php
	$format_in = 'Y-m-d'; // the format your value is saved in (set in the field options)
	$format_out = 'jS M Y'; // the format you want to end up with
	$date = '';
	$date = DateTime::createFromFormat( $format_in, get_field( 'event_start_date') );
	$day = date( 'l', strtotime( get_field( 'event_start_date') ) ) ;
?>
<article class="intention-events-listing-event">
	<a href="<?php the_permalink(); ?>">
		<div class="intention-events-listing-image">
			<a href="<?php the_permalink();?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail( 'large' ); ?>
			</a>
		</div>
	<div class="intention-events-listing-title centre">
		<h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
		<p>
		<?php
			echo $day . ' '; echo $date->format( $format_out ); 
		if ( !empty ( get_field( 'event_start_time' ) ) ) { ?>
		&bull;
			<?php the_field( 'event_start_time' ); ?> - <?php the_field( 'event_end_time' );
		} else {
			echo " &bull; Time TBC";
		}
		?></p>
		<div class="intention-events-event-type has-small-font-size">
			<span class="<?php echo strtolower( get_field( 'event_type' ) ); ?>"><?php the_field( 'event_type' ); ?></span>
		</div>
	</div>
	</a>
</article>