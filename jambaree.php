<?php
/*
* Plugin Name: Jambaree Headless Wordpress - Next.js Utilities
* Plugin URI: https://github.com/Jambaree/jambaree-next-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 2.5.0
* Author: Jambaree
* Author URI: https://jambaree.com/
*/

add_action('acf/init', 'ACFOptionsPage');

function ACFOptionsPage() {
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

require_once(plugin_dir_path(__FILE__) . 'includes/console_log.php');

// Hook into the request to check if we are in the customize preview with is_customize_preview()
// then if we are in the customize preview, we modify the iframe to render the headless site
// instead of the default preview iframe


add_action( 'admin_enqueue_scripts', 'my_customizer_enqueue_script' );
add_action( 'customize_controls_enqueue_scripts', 'my_customizer_enqueue_script' );

function my_customizer_enqueue_script() {
  wp_enqueue_script( 'customizer-headless-preview', plugin_dir_path(__FILE__) . '/js/customizer-iframe.js', array( 'jquery', 'customize-preview' ), '', true );
}