<?php
/*
 * Recent project for Visual Composer
 *

 */

add_action( 'init', 'listings_profile_integrateWithVC' );
function listings_profile_integrateWithVC() {
  vc_map( array(
    "name" => __("Profile Listing", 'listeo'),
    "base" => "profile_listing",
    'icon' => 'listeo_icon',
    'description' => __( 'listings list', 'listeo' ),
    "category" => __('Profile',"listeo"),
    "show_settings_on_create" => true,
    "params" => array(
    	array(
	        'type' => 'textfield',
	        'heading' => __( 'Button Title', 'listeo' ),
	        'param_name' => 'btn_title',
	        'description' =>  __( 'Enter Button Title', 'listeo' ),
        ),
    )
    ));
}



      
?>