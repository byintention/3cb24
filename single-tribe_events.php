<?php
/**
 * The single event template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package intention
 */

$format_in = 'Y-m-d'; // the format your value is saved in (set in the field options)
$format_out = 'F j, Y'; // the format you want to end up with
$date = DateTime::createFromFormat( $format_in, get_field( 'event_start_date') );

get_header(); ?>
<div id="intention-events-single-event">
	<div class="event-banner">
		<?php
		if ( has_post_thumbnail() ) {
			?>
		<div class="event-image">
			<img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
		</div>
			<?php
		}
		?>
		<div class="inner">
			<h1><?php the_title(); ?></h1>
			<h4 class="intention-event-metadata clear has-large-text">
				<?php
					echo $date->format( $format_out ); 
				if ( !empty ( get_field( 'event_start_time' ) ) ) { ?>
				&bull;
					<?php the_field( 'event_start_time' ); ?> - <?php the_field( 'event_end_time' );
				} else {
					echo " &bull; Time TBC";
				}
				?>
			</h4>
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