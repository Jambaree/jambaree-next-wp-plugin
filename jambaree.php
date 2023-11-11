<?php
/*
* Plugin Name: Jambaree
* Plugin URI: https://github.com/Jambaree/jambaree-next-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 2.0.0
* Author: Jambaree
* Author URI: https://jambaree.com/
*/

add_action('plugins_loaded', 'ACFOptionsPage');

function ACFOptionsPage()
{
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

require_once(plugin_dir_path(__FILE__) . 'includes/console_log.php');

/* Template Include */
add_filter('template_include', 'next_preview_template_include', 1, 1);
function next_preview_template_include($template)
{
  if (get_field('headless_preview', 'option')) {

    $is_preview  = is_preview();
    console_log($is_preview);

    if ($is_preview) {
      return plugin_dir_path(__FILE__) . 'includes/preview-template.php'; //Load your template or file
    }

    return $template;
  } else {
    return $template;
  }
}
