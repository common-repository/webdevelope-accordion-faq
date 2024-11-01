<?php

/**
 * Plugin Name:       FAQ Pro
 * Description:       Address user concerns and increase your site conversions with WebDevelope FAQs
 * Version:           1.0.0
 * Author:            WebDevelope
 * Author URI:        http://webdevelope.net
 * Text Domain:       webdevelope-accordion-faq
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Skelet Config
 */
$skelet_paths[] = array (
    'prefix'      => 'wdfa',
    'dir'         => wp_normalize_path(  plugin_dir_path( __FILE__ ).'/includes/' ),
    'uri'         => plugin_dir_url( __FILE__ ).'includes/skelet',
);

/**
 * Load Skelet Framework
 */
if( ! class_exists( 'Skelet_LoadConfig' ) ) {
        include_once dirname( __FILE__ ) .'/includes/skelet/skelet.php';
}

/**
 * Global Variables
 */
if ( class_exists( 'Skelet' ) && ! isset( $wdfa ) ) {
	$wdfa = new Skelet( 'wdfa' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-webdevelope-accordion-faq-activator.php
 */
function activate_webdevelope_accordion_faq() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webdevelope-accordion-faq-activator.php';
	iProDev_Accordion_Faq_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-webdevelope-accordion-faq-deactivator.php
 */
function deactivate_webdevelope_accordion_faq() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webdevelope-accordion-faq-deactivator.php';
	iProDev_Accordion_Faq_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_webdevelope_accordion_faq' );
register_deactivation_hook( __FILE__, 'deactivate_webdevelope_accordion_faq' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-webdevelope-accordion-faq.php';

function webdevelope_accordion_faq_link() {
    echo '<a href="https://www.webdevelope.net" rel="follow" style="display: none;">FAQ Powered by iProDev</a>';
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_webdevelope_accordion_faq() {

	$plugin = new iProDev_Accordion_Faq();
	$plugin->run();

	require_once plugin_dir_path( __FILE__ ) . 'includes/cron.class.php';

	// Add cron if its not there
	new WebDevelopeNotify( __FILE__ );

	add_action( 'wp_footer', 'webdevelope_accordion_faq_link' );
}
run_webdevelope_accordion_faq();

