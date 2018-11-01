<?php

add_filter('show_admin_bar', '__return_false');
require_once( 'src/bootstrap.php' );
add_action('wp_enqueue_scripts', 'enqueue_wpoow_wt_scripts');

// Adding speakers page

$page = get_page_by_title( "speakers" , OBJECT );

if ( !isset($page) ){
    $post_id = wp_insert_post(
        array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_title' => "speakers",
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => 'page-speakers.php'
        )
    );

}