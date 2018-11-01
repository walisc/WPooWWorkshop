<?php

function enqueue_wpoow_wt_scripts(){
    if (!is_admin()) {

        wp_enqueue_script( 'jquery' );
        wp_register_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/src/vendor/bootstrap/js/bootstrap.min.js', array(), '2.5.3', false );
        wp_register_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/src/vendor/bootstrap/css/bootstrap.min.css', array(), '', 'all' );
        wp_register_style( 'heroic-css', get_stylesheet_directory_uri() . '/src/css/heroic-features.css', array(), '', 'all' );
        wp_enqueue_script( 'bootstrap-js' );
        wp_enqueue_style( 'bootstrap-css' );
        wp_enqueue_style( 'heroic-css' );



    }
}



