<?php
add_shortcode( 'profile_email2', 'show_profile_email_field2' );
function show_profile_email_field2($atts = array()){

	extract( $atts = shortcode_atts( array(
			'email_title' => '', 
			'email_sub_title' => '', 
			'email_btn2_title' => 'Anzeige schalten' 
		), $atts ) );
		ob_start();
		if(!empty($email_title) || !empty($email_sub_title)){
			?>
			<h2 style="font-weight:normal;text-align:center;" class="headline margin-top-15 margin-bottom-35 headline-box    headline-aligned-to-center  headline-with-subtitle  "><?php echo $email_title; ?>
				<?php 
				if(!empty($email_sub_title)){ ?>
				<span><?php echo $email_sub_title; ?> </span>
				<?php } ?>
			</h2>
			<?php
		} ?>
		<?php
		$show_email = $show_btn = false;
		$post_status = get_post_field('post_status', $_SESSION['listing_id']);
		if($post_status=="publish"){
			$show_email = true;
		}else{
			$show_btn = true;
		}

		?>
		<div class="vc_wp_search wpb_content_element">
			<div class="widget widget_search">
				<div class="search-blog-input">
			    <form method="POST" class="search-form" action="">
			    	<input type="hidden" id="lp_listing_id" value="<?php echo $_SESSION['listing_id']; ?>">
			    	

			    	<div id="lp_email_field_wrapper" style="<?php echo (!$show_email)?'display:none':''; ?>">
				        <div class="input email_input">
				        	<input class="email-field" type="email" name="listing_claim_email" id="listing_claim_email"  placeholder="Enter your email address to claim listing" value="" />
				        </div>
				        <div class="email_submit">
				        	<div class="vc_btn3-container vc_btn3-center">
								<button style="background-color:#5e0afa; color:#ffffff;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-round vc_btn3-style-custom" title="<?php echo $email_btn2_title; ?>" type="submit" id="lp_email_field_btn"><?php echo $email_btn2_title; ?></button>
							</div>
				        </div>
				    </div>
				    <div id="lp_publish_listing_wrapper" style="<?php echo (!$show_btn)?'display:none':''; ?>">
				    	<div class="email_submit">
				        	<div class="vc_btn3-container vc_btn3-center">
								<button style="background-color:#5e0afa; color:#ffffff;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-round vc_btn3-style-custom" title="<?php echo $email_btn1_title; ?>" type="submit" id="lp_publish_listing_btn"><?php echo $email_btn1_title; ?></button>
							</div>
				        </div>
				    </div>
					<div class="clearfix"></div>
					<div id="listing_claim_success" class="lp_msg_success"><?php echo __('Dein profile ist nun gelistet. Um deinen Account zu verwalten benötigen wir deine E-mail Addresse.', 'listeo'); ?></div>
			    	<div id="listing_email_update" class="lp_msg_success"><?php echo __('Bitte überprüfen Sie Ihre E-Mail-Adresse und setzen Sie das Passwort zurück.', 'listeo'); ?></div>
			    	<div id="listing_email_already_exists" class="lp_msg_error"><?php echo __('Email already exists.', 'listeo'); ?></div>
			    	<div id="listing_email_update_failed" class="lp_msg_error"><?php echo __('Etwas ist schief gelaufen. Bitte versuche es erneut.', 'listeo'); ?></div>
			    	<div id="listing_claim_error" class="lp_msg_error"><?php echo __('Etwas ist schief gelaufen. Bitte versuche es erneut.', 'listeo'); ?></div>
			    	<div id="listing_blank_error" class="lp_msg_error"><?php echo __('Ungültige E-Mail-Adresse. Bitte überprüfen Sie und versuchen Sie es erneut.', 'listeo'); ?></div>
	    		</form>
			</div>
			<div class="clearfix"></div>
			</div>
		</div>
		
		<?php
		return ob_get_clean();
}
