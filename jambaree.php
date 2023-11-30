<?php
/*
* Plugin Name: Jambaree Headless Wordpress - Next.js Utilities
* Plugin URI: https://github.com/Jambaree/jambaree-next-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 2.5.1
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
include_once('wp/customizer-iframe-preview.php');

require_once(plugin_dir_path(__FILE__) . 'includes/console_log.php');