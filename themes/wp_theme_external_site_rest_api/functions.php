<?php

function stijncappetijn_theme_support() {
}
add_action('after_setup_theme', 'stijncappetijn_theme_support');

function stijncappetijn_register_styles() {
    $version = wp_get_theme()->get('Version');
    //wp_enqueue_style( 'stijncappetijn-style', get_stylesheet_uri() );
    wp_enqueue_style('stijncap-style', get_template_directory_uri() . "/style.css", array(), $version, 'all');
}
add_action('wp_enqueue_scripts', 'stijncappetijn_register_styles');

?>
