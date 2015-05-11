<?php
/*
Plugin Name: GP Hub - Driver Widget
Plugin URI: http://www.gp-hub.com/
Description: Show a driver profile in your sidebar
Author: Alex Dovey
Version: 1.1.1
*/

define('GPHUB_DW_DIR', plugins_url('', __FILE__));

defined('ABSPATH') or die("No script kiddies please!");

require_once( dirname(__FILE__) . '/modules/single-driver.php' );
require_once( dirname(__FILE__) . '/modules/standings-combo.php' );


function gphub419231_driver_widget_scripts() {
	wp_register_script( 'gphub_driver_widget_resizejs', GPHUB_DW_DIR . '/js/iframeResizer.min.js', array('jquery'), false, true);
	wp_enqueue_script( 'gphub_driver_widget_resizejs' );
}
 
add_action( 'wp_enqueue_scripts', 'gphub419231_driver_widget_scripts' );

