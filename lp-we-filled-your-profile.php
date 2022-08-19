<?php
/*
Plugin Name: We Filled Your Profile
Plugin URI:
Description: Custom plugin used for "we filled your profile" Functionality
Version: 1.0
Author: latifpala
Text Domain: listeo-wfyp
*/

add_action('vc_after_init', 'lp_run_listeo_vc');
function lp_run_listeo_vc(){
	include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/listings_profile.php' );
	include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/listings_email.php' );
	include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/listings_email2.php' );
}
include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/shortcodes/listings_profile_shortcode.php' );
include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/shortcodes/listings_email_shortcode.php' );
include_once wp_normalize_path( dirname( __FILE__ ) .'/vc_templates/shortcodes/listings_email_shortcode2.php' );

function listeo_wfyp_enqueue_styles() {
	wp_enqueue_script( 'listeo-update-profile', plugin_dir_url( __FILE__ ) . 'js/lp-we-filled-your-profile.js', array('jquery'), '20200721', true );

	wp_enqueue_style( 'listeo-update-profile-style', plugin_dir_url( __FILE__ ) . 'css/lp-we-filled-your-profile.css', array(), '20200721' );

}
add_action ( 'wp_enqueue_scripts', 'listeo_wfyp_enqueue_styles');

add_filter( 'rewrite_rules_array','my_insert_rewrite_rules' );
add_filter( 'query_vars','my_insert_query_vars' );
add_action( 'wp_loaded','my_flush_rules' );

// flush_rules() if our rules are not yet included
function my_flush_rules(){
    $rules = get_option( 'rewrite_rules' );

    if ( ! isset( $rules['(we-filled-your-profile-for-you)/(.*)$'] ) || ! isset( $rules['(listing-preview)/(.*)$'] ) || ! isset( $rules['(edit-listing)/(.*)$'] ) || ! isset( $rules['(add-listing-email)/(.*)$'] )) {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
}

// Adding a new rule
function my_insert_rewrite_rules( $rules )
{
    $newrules = array();
    $newrules['we-filled-your-profile-for-you/(.*)$'] = 'index.php?pagename=we-filled-your-profile-for-you&listing_id=$matches[1]';
    $newrules['listing-preview/(.*)$'] = 'index.php?pagename=listing-preview&listing_id=$matches[1]';
    $newrules['edit-listing/(.*)$'] = 'index.php?pagename=edit-listing&listing_id=$matches[1]';
    $newrules['add-listing-email/(.*)$'] = 'index.php?pagename=add-listing-email&listing_id=$matches[1]';
    return $newrules + $rules;
}

// Adding the id var so that WP recognizes it
function my_insert_query_vars( $vars )
{
    array_push($vars, 'listing_id');
    return $vars;
}

add_action('wp', 'set_session_for_claim_listing');
function set_session_for_claim_listing(){
	if(is_page('listing-preview') || is_page('we-filled-your-profile-for-you') || is_page('edit-listing') || is_page('add-listing-email')){
		set_listing_session();
	}
}

function set_listing_session(){
	global $wp_query;
	if(isset($wp_query->query_vars['listing_id'])) {
		$listing_hash_id = urldecode($wp_query->query_vars['listing_id']);
		$_SESSION['listing_hash_id'] = $listing_hash_id;
		$args = array(
			'post_type' => 'listing',
			'posts_per_page' => 1,
			'meta_key' => 'md5_hash',
			'post_status' => array('preview', 'trash', 'publish', 'expired', 'draft', 'pending_payment'),
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'md5_hash',
					'value' => $listing_hash_id,
					'compare' => '='
				)
			)
		);
		$listing_post = new WP_Query($args);
		if($listing_post->have_posts()):
			while($listing_post->have_posts()):
				$listing_post->the_post();
				$_SESSION['listing_id'] = get_the_ID();
			endwhile;
			wp_reset_postdata();
		else:
			$_SESSION['listing_id'] = 0;
		endif;
	}
}

function lp_update_listing_status_func(){
	$listing_id = $_POST['listing_id'];
	$author_id = get_post_field('post_author', $listing_id);
	$args = array(
		'author' => $author_id, 
		'post_type' => 'listing',
		'post_status' => array('draft')
	);
	$listing_post = new WP_Query($args);
	$listings_updated = false;

	if($listing_post->have_posts()):
		while($listing_post->have_posts()):
			$listing_post->the_post();
			$update_post_arr = array(
				'ID' => get_the_ID(),
				'post_status' => 'publish'
			);
			$update_staus = wp_update_post($update_post_arr);
			$listings_updated = true;
		endwhile;
	endif;
	
	if($listings_updated)
		echo "success";
	else
		echo "failed";
	die;
}
add_action( "wp_ajax_lp_update_listing_status", "lp_update_listing_status_func" );
add_action( "wp_ajax_nopriv_lp_update_listing_status", "lp_update_listing_status_func" );


function lp_update_email_func(){
	$emailid = $_POST['emailid'];
	$listing_id = $_POST['listing_id'];
	$listing = get_post($listing_id);
	$listing_author_id = $listing->post_author;
	
	$args = array(
		'ID' => $listing_author_id,
		'user_email' => $emailid
	);
	if(email_exists($emailid)){
		echo "email_exists";
		die;
	}	
	
	$user_id = wp_update_user($args);
	update_user_meta($user_id, 'wfyp_email_updated', 'updated');
	
	if(is_wp_error($user_id)){
		echo "failed";
	}else{
		lp_send_password_reset_mail($user_id);
		echo "success";
	}
	die;
}
add_action( "wp_ajax_lp_update_email", "lp_update_email_func" );
add_action( "wp_ajax_nopriv_lp_update_email", "lp_update_email_func" );