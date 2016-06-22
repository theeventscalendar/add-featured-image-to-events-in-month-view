<?php
/**
 * Plugin Name: The Events Calendar — Add Featured Image to Events in Month View
 * Description: Adds featured images to the day grid items in the Month View.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

/**
 * Echo the featured image in the "day" grid items in month view.
 *
 * @return void
 */
function tribe_add_featured_image_to_month_view( $slug, $name ) {
	echo tribe_event_featured_image( null, 'medium' );
}

add_action( 'tribe_post_get_template_part_month/single', 'tribe_add_featured_image_to_month_view', 10, 2 );

/**
 * Add CSS at the top of the month view to ensure only one featured image shows.
 *
 * @return void
 */
function tribe_add_featured_image_to_month_view_css() {

	if ( ! tribe_is_month() ) {
		return;
	}
?>
	<style>
	.tribe-events-month .tribe-events-event-image {
		display: none;
	}
	.tribe-events-month .tribe-events-has-events .type-tribe_events + .tribe-events-event-image {
		display: inline-block;
	}
	</style>
<?php
}

add_action( 'tribe_events_after_header', 'tribe_add_featured_image_to_month_view_css' );
