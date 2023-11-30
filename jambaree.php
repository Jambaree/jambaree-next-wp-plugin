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

function my_customizer_enqueue_script() {
  wp_enqueue_script( 'customizer-headless-preview', plugin_dir_url(__FILE__) . 'js/customizer-iframe.js', array( 'jquery', 'customize-preview' ), '', true );
  $headless_site_url = get_field("jambaree_frontend_url", "option");
  wp_localize_script( 'customizer-headless-preview', 'customizerData', array(
      'headlessUrl' => $headless_site_url
  ));
}
add_action( 'customize_controls_enqueue_scripts', 'my_customizer_enqueue_script' );
