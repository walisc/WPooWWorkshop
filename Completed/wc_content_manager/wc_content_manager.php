<?php

/*
Plugin Name: WordCamp 2019 Content Manager
Description: Manager WordCamp 2019 content like speakers and sponsers
Author: Chido Warambwa
Author URI: http://wpoow.devchid.com
*/

//Disallow someone accessing this file out the WordPress context
defined( 'ABSPATH') or die('Accessing this is disallowed');

include_once 'WPooW/wpAPI.php';
include_once 'CustomRatingSelectorSimple/CustomRatingSelectorSimple.php';

class WcContentManager{

    //Only accessible within this class
    private $WPooW;

    function __construct(){
        $this->WPooW = new wpAPI();
        
        $wcSponsors = $this->CreateSponsorsPostType();
        $wcSpeakers =$this->CreateSpeakersPostType();

        //$wc_cm_menu = $this->WPooW->CreateMenu("_wc_content_manager", "WC Content Manager");
        // $wc_cm_menu->AddChild($wcSponsors);
        // $wc_cm_menu->AddChild($wcSpeakers);
        // $wc_cm_menu->Render();

        $menuLanding_page = new wpAPI_VIEW(wpAPI_VIEW::PATH, get_backend_template("Landing.twig"), ["wpoow_version" => $this->WPooW->GetVersion()]);
        $wc_cm_menu = $this->WPooW->CreateMenu("_wc_content_manager", "WC Content Manager",  WP_PERMISSIONS::MANAGE_OPTIONS, $menuLanding_page, $icon='dashicons-admin-site');

        $wc_cm_menu->AddChild($wcSponsors);
        $wc_cm_menu->AddChild($wcSpeakers);

        $setting_page = new wpAPI_VIEW(wpAPI_VIEW::PATH, get_backend_template("Settings.twig"), []);
        $wc_cm_setting = $this->WPooW->CreateSubMenu("_wc_setting", "Settings",  WP_PERMISSIONS::MANAGE_OPTIONS, $setting_page);
        $wc_cm_menu->AddChild($wc_cm_setting);

        $wc_cm_menu->Render();
    }

    function CreateSponsorsPostType(){

        $sponsorship_level_options = [
            "Bronze" => "Bronze",
            "Silver" => "Silver",
            "Gold" => "Gold",
        ];


        //Add icons later
        $wcSponsors = $this->WPooW->CreatePostType("_wc_sponsors", "Sponsors", true, [
            "menu_icon" => "dashicons-tickets-alt"
        ]);
        $wcSponsors->AddField( new Text("_name", "Name"));
        $wcSponsors->AddField( new TextArea("_description", "Description"));
        $wcSponsors->AddField( new Uploader("_logo", "Logo"));
        $wcSponsors->AddField( new Text("_url", "Url"));
        $wcSponsors->AddField( new CustomRatingSelectorSimple("_sponsorship_level", "Sponsorship Level"));
        return $wcSponsors;
    }

    function CreateSpeakersPostType(){

        $presenting_as_options = [
            "Bronze" => "Developer",
            "Silver" => "Entrepreneur",
            "Gold" => "Techie",
        ];

        $permissions = [
            wpAPIPermissions::AddPage => "",
            wpAPIPermissions::EditPage =>  "r"
        ];
        

        $wcSpeakers = $this->WPooW->CreatePostType("_wc_speakers", "Speakers", true);
        $wcSpeakers->AddField( new Text("_id", "ID", $permissions ));
        $wcSpeakers->AddField( new Text("_name", "Name"));
        $wcSpeakers->AddField( new Text("_wp_username", "WP username"));
        $wcSpeakers->AddField( new RichTextArea("_description", "Description"));
        $wcSpeakers->AddField( new Uploader("_photo", "Photo"));
        $wcSpeakers->AddField( new MultiSelect("_presenting_as", "Presenting As", $presenting_as_options));
        $wcSpeakers->AddField( new Checkbox("_is_active", "Is Active"));
        $wcSpeakers->RegisterBeforeSaveEvent("CreateSpeakersID", $this);
        $wcSpeakers->RegisterBeforeDataFetch("ReorderSpeakers", $this);
        $wcSpeakers->RegisterAfterSaveEvent("SendSpeakerEmail", $this);
        return $wcSpeakers;
    }

    function CreateSpeakersID($data){
        $data["_id"] = sanitize_title($data[sprintf("%s_%s", "_wc_speakers", "_name")]);
        return $data;
    }

    function ReorderSpeakers($query){
        $query->set('order', 'ASC');
        $query->set('orderby', 'meta_value');
        $query->set('meta_key',  sprintf("%s_%s_value_key", "_wc_speakers", "_name"));
    }

    function SendSpeakerEmail($data){
        $namePostTypeId = sprintf("%s_%s", "_wc_speakers", "_name");
        $isActivePostTypeId = sprintf("%s_%s", "_wc_speakers", "_is_active");

        if ($data[$isActivePostTypeId] == "on"){
            wp_mail("chido@batanasoftware.com", 
            "Please check your info", 
            sprintf("Hi %s. Please check your info on the WordCamp website ",$data[$namePostTypeId]));
            return $data;
        }
    }
    //WordPress hooks
    function OnActivate(){
        flush_rewrite_rules();
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


function get_backend_template($template)
{
    return 'wp-content'. DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR. basename(__FILE__, ".php") . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR  .$template;

}

//Using mail Dev maildev npm install -g maildev (access on localhost:1080)
add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
	$phpmailer->isSMTP();
	$phpmailer->Host       = "localhost";
    $phpmailer->Port       = 1025;
    $phpmailer->SMTPAuth       = false;
    $phpmailer->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

}