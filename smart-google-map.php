<?php
/*
 * Plugin Name: Smart Google Map
 * Plugin URI:  https://imdr.github.io/smart-google-map
 * Description: Just an another Google Map plugin
 * Version:     1.5
 * Author:      Dinesh Rawat
 * Author URI:  https://imdr.github.io/
 * Text Domain: smart-google-map
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


include_once('inc/sgm-custom-post.php');
include_once('inc/sgm-meta-box.php');
include_once('inc/sgm-settings-page.php');
include_once('inc/sgm-shortcode.php');


function smart_google_map_activate() {
	update_option( 'google_map_api_key', 'AIzaSyAG4g80Kr11NKX1sxPX-VFYUFM7qfv8b6g');
}
register_activation_hook( __FILE__, 'smart_google_map_activate' );

?>