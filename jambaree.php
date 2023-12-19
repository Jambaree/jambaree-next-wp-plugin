<?php
/*
* Plugin Name: Jambaree Headless Wordpress - Next.js Utilities
* Plugin URI: https://github.com/Jambaree/jambaree-next-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 2.7.0
* Author: Jambaree
* Author URI: https://jambaree.com/
*/

add_action('acf/init', 'jambaree_acf_init');

function jambaree_acf_init() {
  if (class_exists('acf')) {
    include_once('acf/options-page.php');

    if (get_field('flexible_content', 'options')) :
      include_once('acf/flexible-content.php');
    endif;

    if (get_field('decapitate_wp', 'options')) :
      include_once('wp/decapitate-wp.php');
    endif;

    if (have_rows('menu_locations', 'options')) :
      include_once('wp/add-menu-locations.php');
    endif;
  }
}

include_once('wp/rest-endpoint-options-page.php');
include_once('wp/rest-menu-items-add-acf.php');
include_once('wp/headless-preview.php');
include_once('acf/populate-post-type-choices.php');
include_once('wp/customizer-iframe-preview.php');

require_once(plugin_dir_path(__FILE__) . 'includes/console_log.php');

add_action('init', 'handle_preflight');
function handle_preflight() {
    // This is for CORS when using the WP REST API, especially when submitting Gravity Forms
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Origin, Content-Type, Accept");

    if('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
        status_header(200);
        exit();
    }
}

function jambaree_acf_google_map_api( $api ){
  $apiKey = get_field('jambaree_google_maps_api_key', 'options');
  if ($apiKey) {
    $api['key'] = $apiKey;
  }
  return $api;
}
add_filter('acf/fields/google_map/api', 'jambaree_acf_google_map_api');
