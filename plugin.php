<?php
/**
 * Plugin Name: The Events Calendar Extension: Add Featured Image to Events in Month View
 * Description: Adds featured images to the day grid items in the Month View.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Add_Featured_Image_to_Events_in_Month_View {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main' => '4.2',
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_action( 'tribe_post_get_template_part_month/single', array( $this, 'tribe_add_featured_image_to_month_view' ), 10, 2 );
        add_action( 'tribe_events_after_header', array( $this, 'tribe_add_featured_image_to_month_view_css' ) );
    }

    /**
     * Echo the featured image in the "day" grid items in month view.
     *
     * @return void
     */
    public function tribe_add_featured_image_to_month_view( $slug, $name ) {
        echo tribe_event_featured_image( null, 'medium' );
    }

    /**
     * Add CSS at the top of the month view to ensure only one featured image shows.
     *
     * @return void
     */
    public function tribe_add_featured_image_to_month_view_css() {
    
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
}

new Tribe__Extension__Add_Featured_Image_to_Events_in_Month_View();
