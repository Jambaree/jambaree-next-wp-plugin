<?php
/* Load preview iframe template if we are in preview */
add_filter('template_include', 'next_preview_template_include', 1, 1);
function next_preview_template_include($template) {
  if (get_field('headless_preview', 'option')) {

    $is_customize_preview = is_customize_preview();
    console_log($is_customize_preview);
    error_log("is_customize_preview: " . $is_customize_preview);
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
?>