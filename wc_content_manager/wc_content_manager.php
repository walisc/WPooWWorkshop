<?php

/*
Plugin Name: WordCamp 2019 Content Manager
Description: Manager WordCamp 2019 content like speakers and sponsers
Author: Chido Warambwa
Author URI: http://wpoow.devchid.com
*/

//Disallow someone accessing this file out the WordPress context
defined( 'ABSPATH') or die('Accessing this is disallowed');

class WcContentManager{

    function __construct(){}

    //WordPress hooks
    function OnActivate(){
    }

    function OnDeactivate(){
        //TODO: Implement
    }

    function OnUninstall(){
        //TODO: Implement
    }
}


$WcContentManager = new WcContentManager();
register_activation_hook(__FILE__, [$WcContentManager, 'OnActivate']);
register_deactivation_hook(__FILE__, [$WcContentManager, 'OnDeactivate']);