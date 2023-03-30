<?php
if (function_exists('acf_add_options_page')) :

  acf_add_options_page(array(
    'page_title'   => 'Bare WordPress',
    'menu_title'  => 'Bare',
    'menu_slug'   => 'bare',
    'capability'  => 'edit_posts',
    'icon_url' => 'dashicons-editor-code',
    'position' => 2,
    'redirect'    => false
  ));

  acf_add_options_page(array(
    'page_title'   => 'Theme Options',
    'menu_title'  => 'Theme Options',
    'menu_slug'   => 'theme-options',
    'capability'  => 'edit_posts',
    'icon_url' => 'dashicons-editor-code',
    'position' => 2,
    'redirect'    => false,
    'show_in_graphql' => true
  ));

endif;


if (function_exists('acf_add_local_field_group')) :
  acf_add_local_field_group(array(
    'key' => 'group_1',
    'title' => 'Features',
    'fields' => array(
      array(
        'key' => 'bare_admin_theme',
        'label' => 'Bare Admin Theme',
        'instructions' => 'Simplify Admin Theme',
        'name' => 'bare_admin_theme',
        'type' => 'true_false',
        'message' => 'Activate'
      ),
      array(
        'key' => 'decapitate_wp',
        'label' => 'Decapitate WP',
        'instructions' => 'Redirect frontend',
        'name' => 'decapitate_wp',
        'type' => 'true_false',
        'message' => 'Activate'
      ),
      array(
        'key' => 'flexible_content',
        'label' => 'Flexible Content',
        'instructions' => 'Auto add elements with title "Module: (...)" to flexible content section on default page template',
        'name' => 'flexible_content',
        'type' => 'true_false',
        'message' => 'Activate'
      ),
      array(
        'key' => 'field_623cd145eee11',
        'label' => 'Modules Post Types',
        'name' => 'modules_post_types',
        'type' => 'repeater',
        'instructions' => 'Additional post types to add the Modules field group to.',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'show_in_graphql' => 1,
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => '',
        'sub_fields' => array(
          array(
            'key' => 'field_623cd16deee12',
            'label' => 'Post Type',
            'name' => 'post_type_choices',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
              'width' => '',
              'class' => '',
              'id' => '',
            ),
            'show_in_graphql' => 1,
            'choices' => array(),
            'default_value' => false,
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
          ),
        ),
      ),
      array(
        'key' => 'gravity_forms_file_upload_fix',
        'label' => 'GravityForms file upload fix',
        'instructions' => 'Enables uploads for files transmitted in base64 format',
        'name' => 'gravity_forms_file_upload_fix',
        'type' => 'true_false',
        'message' => 'Activate'
      ),
      array(
        'key' => 'menu_locations',
        'label' => 'Menu Locations',
        'name' => 'menu_locations',
        'type' => 'repeater',
        'instructions' => 'Add menu locations here (required to show menus in GraphQL)',
        'show_in_graphql' => 1,
        'layout' => 'block',
        'button_label' => 'Add Menu Location',
        'sub_fields' => array(
          array(
            'key' => 'menu_location_name',
            'label' => 'Name',
            'name' => 'menu_location_name',
            'type' => 'text',
            'required' => 1,
            'show_in_graphql' => 1,
            'wrapper' => array(
              'width' => '50%',
            ),
          ),
          array(
            'key' => 'menu_location_slug',
            'label' => 'Slug',
            'name' => 'menu_location_slug',
            'type' => 'text',
            'required' => 1,
            'show_in_graphql' => 1,
            'wrapper' => array(
              'width' => '50%',
            ),
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'bare',
        ),
      ),
    ),
    'menu_order' => 1,
    'style' => 'default',
  ));

endif;
