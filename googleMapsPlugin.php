<?php
/**
 * @package GooglePlugin
 * Plugin Name:Google maps plugin
 * Description:Add google maps to your website
 * Version 1.0
 * Author: Alex
 * Author URI:http
 * Text Domain:
 */

defined('ABSPATH') or die('Omae wa mou shindeiru');

class ClassCustomMap{

    public $plugin;

    function __construct()
    {
        $this->plugin=plugin_basename(__FILE__);
        add_shortcode("ppA",array($this,'iframeP'));
    }

    function register(){
        add_action('admin_menu',array($this,'addMenu'));
        add_filter("plugin_action_links_$this->plugin",array($this,'settings_link'));
    }
    
    public function settings_link($links){
        $settings_link='<a href="options-general.php?page=maps-google-settings">Settings</a>';
        array_push($links,$settings_link);
        return $links;
    }

    function iframeP(){            
        $r='<iframe width="'.$this->setWidth().'" height="'.$this->setHeight().'" id="gmap_canvas" src="https://maps.google.com/maps?q='.$this->setLocation().'&t=&z='.$this->setZoom().'&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>';
        return $r ;
    }

    function setLocation(){
        if(is_null(get_option('db-google-maps-location')) || empty( get_option('db-google-maps-location'))){
            return 'easv';
        }else{
            $location=get_option('db-google-maps-location');
            $location = str_replace(' ', '%20', $location);
            return $location;
        }
    }

    function setHeight(){
        if(is_null(get_option('db-google-maps-height')) || empty( get_option('db-google-maps-height'))){
            return '500';
        }else{
            $height=get_option('db-google-maps-height');
            return $height;
        }
    }

    function setZoom(){
        if(is_null(get_option('db-google-maps-zoom')) || empty( get_option('db-google-maps-zoom'))){
            return '15';
        }else{
            $zoom=get_option('db-google-maps-zoom');
            return $zoom;
        }
    }

    function setWidth(){
        if(is_null(get_option('db-google-maps-width')) || empty( get_option('db-google-maps-width'))){
            return '600';
        }else{
            $width=get_option('db-google-maps-width');
            return $width;
        }
    }
    
    function addMenu(){
        add_menu_page(
            'Configuration',
            'Google Maps Options',
            'administrator',
            'maps-google-settings',
            array($this,'create_settings_page'),
            'dashicons-admin-generic'
        );

        add_settings_section(
            "menumaps",
            "Gpogle maps Menu f",
            null,
            "dbgooglemaps"
        );

        register_setting(
            "menumaps",
            "db-google-maps-location",
        );

        add_settings_field(
            "db-google-maps-location", //id
            "Google maps location", //name to display
            array($this, "google_location"), //callback function
            "dbgooglemaps", //page itentifier
            "menumaps" //Section to add the field into
        );

        register_setting(
            "menumaps",
            "db-google-maps-height",
        );

        add_settings_field(
            "db-google-maps-height", //id
            "Google maps height iframe", //name to display
            array($this, "google_height"), //callback function
            "dbgooglemaps", //page itentifier
            "menumaps" //Section to add the field into
        );

        register_setting(
            "menumaps",
            "db-google-maps-width",
        );

        add_settings_field(
            "db-google-maps-width", //id
            "Google maps width iframe", //name to display
            array($this, "google_width"), //callback function
            "dbgooglemaps", //page itentifier
            "menumaps" //Section to add the field into
        );

        register_setting(
            "menumaps",
            "db-google-maps-zoom",
        );

        add_settings_field(
            "db-google-maps-zoom", //id
            "Google maps zoom iframe", //name to display
            array($this, "google_zoom"), //callback function
            "dbgooglemaps", //page itentifier
            "menumaps" //Section to add the field into
        );

        
    }

    public function google_location()
    {
        echo '<input type="text" name="db-google-maps-location" value="' . get_option('db-google-maps-location') . '"/>';
    }
    
    public function google_height()
    {
        if(is_null(get_option('db-google-maps-height')) || empty( get_option('db-google-maps-height')) ){
            echo '<input type="number" name="db-google-maps-height" value="500"/>';
        }else{
            echo '<input type="number" name="db-google-maps-height" value="' . get_option('db-google-maps-height') . '"/>';
        }
    }
    
    public function google_zoom()
    {
        if(is_null(get_option('db-google-maps-zoom')) || empty( get_option('db-google-maps-zoom')) ){
            echo '<input type="number" min="1" max="20" name="db-google-maps-zoom" value="15"/>';
        }else{
            echo '<input type="number" min="1" max="20" name="db-google-maps-zoom" value="' . get_option('db-google-maps-zoom') . '"/>';
        }
    }
    
    public function google_width()
    {
        if(is_null(get_option('db-google-maps-width')) || empty( get_option('db-google-maps-width')) ){
            echo '<input type="number" name="db-google-maps-width" value="600"/>';
        }else{
            echo '<input type="number" name="db-google-maps-width" value="' . get_option('db-google-maps-width') . '"/>';
        }
	}

    public function create_settings_page()
    {
        echo '<div class="wrap">
	          <h1>DB Enabled Plugin Settings</h1>
  		 	  <!-- options.php is a Wordpress file that does most logic -->
	          <form method="post" action="options.php">';
		
		// Inset section, fields and save button
        do_settings_sections("dbgooglemaps"); //output all settings sections 
        settings_fields("menumaps"); //WP built-in function
        submit_button();
		
		echo '</form></div>';
	}
    
    
}

if(class_exists('ClassCustomMap')){
    $objClassCustomMap= new ClassCustomMap();
    $objClassCustomMap->register();
}

require_once plugin_dir_path(__FILE__). 'inc/googleMaps-plugin-activate.php';
register_activation_hook(__FILE__,array('ClassCustomMapActivate','activate'));

require_once plugin_dir_path(__FILE__). 'inc/googleMaps-plugin-deactivate.php';
register_deactivation_hook(__FILE__,array('ClassCustomMapDeactivate','deactivate'));



