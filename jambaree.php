<?php
/*
* Plugin Name: Jambaree
* Plugin URI: https://github.com/Jambaree/jambaree-next-wp-plugin
* Description: Everything you need for a headless Wordpress sites in one place
* Version: 2.1.0
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


add_action('rest_api_init', function () {
  register_rest_route('jambaree/v1', '/options/(?P<slug>[a-zA-Z0-9-]+)', array(
      'methods' => 'GET',
      'callback' => 'jambaree_get_acf_options_page',
      'permission_callback' => function (WP_REST_Request $request) {
          return current_user_can('administrator');
      }
  ));
});

function jambaree_get_acf_options_page($request) {
  $options_pages = acf_get_options_pages();
  $slug = $request['slug'];

  $options_page = $options_pages[$slug];
  
  if (!$options_page) {
    return new WP_Error('not_found', 'Options page not found', array('status' => 404));
  }
  
  // Fetch the fields for the found options page
  $fields = get_fields($options_page["post_id"]);

  return $fields ?: new WP_Error('no_fields', 'No fields found for this options page', array('status' => 404));
}