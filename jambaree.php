<?php
/*
* Plugin Name: Bare
* Plugin URI: https://github.com/Jambaree/bare-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 0.2
* Author: Robin Zimmer / Caleb Barnes
* Author URI:
*/

define('BARE_URL', plugin_dir_url(__FILE__));
define('BARE_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', 'ACFOptionsPage');

function ACFOptionsPage()
{


  if (class_exists('acf')) {

    include_once('acf/options-page.php');

    if (get_field('flexible_content', 'options')) :
      include_once('acf/flexible-content.php');
    endif;

    if (get_field('bare_admin_theme', 'options')) :
      include_once('menu/bare-theme.php');
    endif;

    if (get_field('decapitate_wp', 'options')) :
      include_once('wp/decapitate-wp.php');
    endif;

    if (have_rows('menu_locations', 'options')) :
      include_once('wp/add-menu-locations.php');
    endif;

    if (get_field('gravity_forms_file_upload_fix', 'options')) :
      include_once('gravityforms/file-upload.php');
    endif;
  }
}


add_filter("acf/prepare_field/name=post_type_choices", "acf_populate_post_type_choices", 999, 1);

function acf_populate_post_type_choices($field)
{
  // reset choices
  $field['choices'] = array();

  $post_types = get_post_types(array('show_in_nav_menus' => true), 'objects');

  foreach ($post_types as $post_type) {
    $field['choices'][$post_type->name] = $post_type->label . " (" . $post_type->name . ")";
  }
  return $field;
}
