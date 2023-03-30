<?php

require_once( BARE_PATH . "/menu/bare-theme-menu.php");

add_action( 'admin_enqueue_scripts', 'add_bare_theme_scripts' );
function add_bare_theme_scripts() {   
    wp_register_script( 'menu', BARE_URL . "/menu/assets/js/bare-theme-menu.js", array('jquery') );
    wp_enqueue_script( 'menu' );

    wp_enqueue_style( 'betteradmin-style', BARE_URL . "/menu/assets/css/style.css" );
}

?>