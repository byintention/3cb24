<?php
/**
 * The event listing template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package intention
 */

get_header(); ?>
<div id="intention-events-listing">
	<div class="container">
		<div class="twelve columns">
		<?php
		$queries = array();
		parse_str( $_SERVER['QUERY_STRING'], $queries );
		if ( ! isset( $queries['eventDisplay'] ) ) {
			?>
			<h1 class="centre">Upcoming Events</h1>
			<?php
			$today  = gmdate( 'Y-m-d' );
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args = array(
				'post_type'      => 'tribe_events',
				'meta_key'       => 'event_start_date',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC',
				'paged'          => $paged,
				'meta_query'     => array(
					array(
						'key'     => 'event_start_date',
						'compare' => '>=',
						'value'   => gmdate( 'Y-m-d h:i' ),
						'type'    => 'DATE',
					),
				),
			);
			$event_query = new WP_Query( $args );
			if ( $event_query->have_posts() ) {
				while ( $event_query->have_posts() ) {
					$event_query->the_post();
					get_template_part( 'includes/event-info' );
				}
				?>
				<div class="intention-events-listing-navigation future">
					<?php
					if ( 1 == $paged ) { ?>
					<a href="/events/?eventDisplay=past">&laquo; Past events</a>	
						<?php
					}
					sv_pagination( 'future' ); ?>
				</div>
				<?php
				wp_reset_postdata();
			} else {
				?>
				<p class="info centre">No events upcoming.</p>
				<?php
			} // End event loop.
		} // End test if does not have query string for past events.
		
		if ( ( isset( $queries['eventDisplay'] ) ) && 'past' === $queries['eventDisplay'] ) {
			?>
			<h1 class="centre">Past Events</h1>
			<?php
			$today = gmdate( 'Y-m-d' );
			$paged      = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args        = array(
				'post_type'      => 'tribe_events',
				'meta_key'       => 'event_start_date',
				//'posts_per_page' => 1,
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
				'paged'          => $paged,
				'meta_query'     => array(
					array(
						'key'     => 'event_start_date',
						'compare' => '<',
						'value'   => gmdate( 'Y-m-d h:i' ),
						'type'    => 'DATE',
					),
				),
			);
			$event_query = new WP_Query( $args );
			if ( $event_query->have_posts() ) {
				while ( $event_query->have_posts() ) {
					$event_query->the_post();
					get_template_part( 'includes/event-info' );
				}
				?>
				<div class="intention-events-listing-navigation">
					<?php
					sv_pagination('');
					if ( $paged === 1 ) {
						echo '<a href="/events/" class="right">Upcoming events »</a>';
					}
					?>
				</div>
				<?php
				wp_reset_postdata();
			} else {
				?>
				<p class="info centre">No past events.</p>
				<?php
			} // End event loop.
		} // End test if does have query string for past events.
		?>
		</div>
	</div>
</div>
<?php get_footer(); ?>