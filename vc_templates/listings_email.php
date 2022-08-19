<?php
/*
 * Recent project for Visual Composer
 *

 */

add_action( 'init', 'listings_email_integrateWithVC' );
function listings_email_integrateWithVC() {
  vc_map( array(
    "name" => __("Profile Email", 'listeo'),
    "base" => "profile_email",
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
            'heading' => __( 'Publish Button Title', 'listeo' ),
            'param_name' => 'email_btn1_title',
            'description' =>  __( 'This will be used as publish listing button title', 'listeo' ),
            'default' => __('Put listing online now', 'listeo')
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Email Button Title', 'listeo' ),
            'param_name' => 'email_btn2_title',
            'description' =>  __( 'This will be used as update email for user.', 'listeo' ),
        ),
        array(
            'type' => 'textarea',
            'heading' => __( 'Description', 'listeo' ),
            'param_name' => 'email_description',
            'description' =>  __( 'This will be displayed underneath email box.', 'listeo' ),
        ),
        
    )
    ));
}
?>