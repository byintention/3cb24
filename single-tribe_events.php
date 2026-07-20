<?php
/**
 * The single event template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package intention
 */

$format_in   = 'Y-m-d'; // the format your value is saved in (set in the field options).
$format_out  = 'jS M Y'; // the format you want to end up with.
$is_date_set = ! empty( get_field( 'event_start_time' ) );
if ( $is_date_set ) {
	$date_str = DateTime::createFromFormat( $format_in, get_field( 'event_start_date' ) )->format( $format_out );

	// event_start_date/event_start_time are entered in UK time. This gives event-local-time.js
	// a timezone-aware timestamp to convert to the visitor's own browser timezone.
	$event_start_datetime = DateTime::createFromFormat(
		'Y-m-d g:i a',
		get_field( 'event_start_date' ) . ' ' . get_field( 'event_start_time' ),
		new DateTimeZone( 'Europe/London' )
	);
	$event_start_iso      = $event_start_datetime ? $event_start_datetime->format( DATE_ATOM ) : '';
	$event_start_tz_abbr  = $event_start_datetime ? $event_start_datetime->format( 'T' ) : '';
} else {
	$date_str            = 'Date TBC';
	$event_start_iso     = '';
	$event_start_tz_abbr = '';
}
$day = date( 'l', strtotime( get_field( 'event_start_date') ) ) ;
get_header(); ?>
<div id="intention-events-single-event">
	<div class="event-banner">
		<?php
		if ( has_post_thumbnail() ) {
			?>
		<div class="event-image">
			<picture>
				<source media="(max-width:599px)" srcset="<?php the_post_thumbnail_url( 'large' ); ?>">
				<source media="(min-width:600px)" srcset="<?php the_post_thumbnail_url(); ?>">
				<img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>">
			</picture>
		</div>
			<?php
		}
		?>
		<div class="inner">
			<h1><?php the_title(); ?></h1>
			<p class="intention-event-metadata clear has-large-text">
				<?php
				echo $day . ' '; echo esc_html( $date_str );
				echo '<br>';
				if ( $is_date_set ) {
					?>
					<?php echo esc_html( tcb24_format_24_hour_time( get_field( 'event_start_time' ) ) ); ?> -
					<?php
					echo esc_html( tcb24_format_24_hour_time( get_field( 'event_end_time' ) ) );
					echo ' ' . esc_html( $event_start_tz_abbr );
					?>
					<span class="event-local-time" data-event-start="<?php echo esc_attr( $event_start_iso ); ?>"></span>
					<?php
				} else {
					echo 'Time TBC';
				}
				?>
			</p>
			<div class="intention-events-event-type has-small-font-size">
				<?php
					$missionType = get_field( 'brief_mission_type' );
				?>
				<span class="<?php echo $missionType[ 'value' ]; ?>"><?php echo $missionType[ 'label' ]; ?></span>
			</div>
		</div>
		<div class="tint"></div>
	</div>
	<div class="container">
		<div class="twelve columns">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
				<div class="post intention-event" id="post-<?php the_ID(); ?>">
					<?php
					do_action( 'tribe_events_single_event_after_the_meta' );
					?>
				</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
