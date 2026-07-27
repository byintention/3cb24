<?php
	$format_in  = 'Y-m-d'; // the format your value is saved in (set in the field options)
	$format_out = 'jS M Y'; // the format you want to end up with
	$date       = DateTime::createFromFormat( $format_in, get_field( 'event_start_date' ) );
	$day        = date( 'l', strtotime( get_field( 'event_start_date' ) ) );

	$is_time_set = ! empty( get_field( 'event_start_time' ) );
	if ( $is_time_set ) {
		// event_start_date/event_start_time are entered in UK time. This gives event-local-time.js
		// a timezone-aware timestamp to convert to the visitor's own browser timezone.
		$event_start_datetime = DateTime::createFromFormat(
			'Y-m-d g:i a',
			get_field( 'event_start_date' ) . ' ' . get_field( 'event_start_time' ),
			new DateTimeZone( 'Europe/London' )
		);
		$event_start_iso     = $event_start_datetime ? $event_start_datetime->format( DATE_ATOM ) : '';
		$event_start_tz_abbr = $event_start_datetime ? $event_start_datetime->format( 'T' ) : '';
	} else {
		$event_start_iso     = '';
		$event_start_tz_abbr = '';
	}
?>
<article class="intention-events-listing-event">
	<a href="<?php the_permalink(); ?>">
		<div class="intention-events-listing-image">
			<img loading="lazy" src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?> banner">
		</div>
	<div class="intention-events-listing-title centre">
		<h3><?php the_title(); ?></h3>
		<p>
		<?php
			echo $day . ' '; echo $date->format( $format_out );
		if ( $is_time_set ) {
			?>
			<br>
			<?php echo esc_html( tcb24_format_24_hour_time( get_field( 'event_start_time' ) ) ); ?> - <?php echo esc_html( tcb24_format_24_hour_time( get_field( 'event_end_time' ) ) ); ?> <?php echo esc_html( $event_start_tz_abbr ); ?>
			<span class="event-local-time" data-event-start="<?php echo esc_attr( $event_start_iso ); ?>"></span>
			<?php
		} else {
			echo " Time TBC";
		}
		?></p>
		<div class="intention-events-event-type has-small-font-size">
			<?php
				$missionType = get_field( 'brief_mission_type' );
			?>
			<span class="<?php echo strtolower( $missionType[ 'value' ] ); ?>"><?php echo $missionType[ 'label' ]; ?></span>
		</div>
	</div>
	</a>
</article>