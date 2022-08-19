<?php
/*
 * Recent project for Visual Composer
 *

 */

add_action( 'init', 'listings_email2_integrateWithVC' );
function listings_email2_integrateWithVC() {
  vc_map( array(
    "name" => __("Profile Email Single", 'listeo'),
    "base" => "profile_email2",
    'icon' => 'listeo_icon',
    'description' => __( 'Email field for claiming listing', 'listeo' ),
    "category" => __('Profile',"listeo"),
    "show_settings_on_create" => true,
    "params" => array(
    	array(
	        'type' => 'textfield',
	        'heading' => __( 'Title', 'listeo' ),
	        'param_name' => 'email_title',
	        'description' =>  __( 'Enter Title', 'listeo' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Subtitle', 'listeo' ),
            'param_name' => 'email_sub_title',
            'description' =>  __( 'Enter Subtitle', 'listeo' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Email Button Title', 'listeo' ),
            'param_name' => 'email_btn2_title',
            'description' =>  __( 'This will be used as update email for user.', 'listeo' ),
        ),
    )
    ));
}
?>