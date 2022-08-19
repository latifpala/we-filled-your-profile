<?php
add_shortcode( 'profile_email', 'show_profile_email_field' );
function show_profile_email_field($atts = array()){

	extract( $atts = shortcode_atts( array(
			'email_title' => '', 
			'email_sub_title' => '', 
			'email_btn1_title' => 'Jetzt Anzeige schalten',
			'email_btn2_title' => 'E-Mail verwenden',
			'email_description' => ''

		), $atts ) );
		
		$show_email = $show_btn = $show_btn_no_email = $show_nothing = false;

		$post_status = get_post_field('post_status', $_SESSION['listing_id']);
		$author_id = get_post_field('post_author', $_SESSION['listing_id']);

		$email_status = get_user_meta($author_id, 'wfyp_email_updated', true);

		$args = array(
		  'author' => $author_id, 
		  'post_type' => 'listing',
		  'post_status' => array('draft'),
		  'fields' => 'ids',
		  'posts_per_page' => -1
		);
		$listings_available = get_posts($args);

		if(empty($listings_available) && $email_status=="updated"){
			$show_nothing = true;
		}elseif(!empty($listings_available) && $email_status=="updated"){
			$show_btn_no_email = true;
		}

		if(empty($listings_available) && $email_status==""){
			$show_email = true;
		}elseif(!empty($listings_available) && $email_status==""){
			$show_btn = true;
		}

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
		
		<div class="vc_wp_search wpb_content_element">
			<div class="widget widget_search">
				<div class="search-blog-input">
			    <form method="POST" class="search-form" action="">
			    	<input type="hidden" id="lp_listing_id" value="<?php echo $_SESSION['listing_id']; ?>">

			    	
			    	<?php
			    	if(!$show_btn_no_email){ ?>
			    	<div id="lp_email_field_wrapper" style="<?php echo (!$show_email)?'display:none':''; ?>">
				        <div class="input email_input">
				        	<input class="email-field" type="email" name="listing_claim_email" id="listing_claim_email"  placeholder="<?php echo __('z.B. sexbomb@web.de', 'listeo'); ?>" value="" />
				        </div>
				        <div class="email_submit">
				        	<div class="vc_btn3-container vc_btn3-center">
								<button style="background-color:#5e0afa; color:#ffffff;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-round vc_btn3-style-custom" title="<?php echo $email_btn2_title; ?>" type="submit" id="lp_email_field_btn"><?php echo $email_btn2_title; ?></button>
							</div>
				        </div>
				    </div>
					<?php } ?>

				    <div id="lp_publish_listing_wrapper" style="<?php echo (!$show_btn)?'display:none':''; ?>">
				    	<div class="email_submit">
				        	<div class="vc_btn3-container vc_btn3-center">
								<button style="background-color:#5e0afa; color:#ffffff;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-round vc_btn3-style-custom" title="<?php echo $email_btn1_title; ?>" type="submit" id="lp_publish_listing_btn"><?php echo $email_btn1_title; ?></button>
							</div>
				        </div>
				    </div>
					<div class="clearfix"></div>
					
					<?php 
			    	if($show_nothing): ?>
						<div class="lp_msg_error" style="display: block;"><?php echo __('You have no listings to claim. You have already updated your email.', 'listeo'); ?></div>
			    	<?php endif; ?>

					<div id="listing_claim_success" class="lp_msg_success"><?php echo __('Dein Profil ist nun gelistet. Um deinen Account zu verwalten benötigen wir deine E-mail Addresse.', 'listeo'); ?></div>
			    	<div id="listing_email_update" class="lp_msg_success"><?php echo __('Du hast Mail! Bitte öffne dein E-Mail Postfach und setze dein Passwort.', 'listeo'); ?></div>
			    	<div id="listing_email_already_exists" class="lp_msg_error"><?php echo __('E-Mail Adresse wird bereits genutzt.', 'listeo'); ?></div>
			    	<div id="listing_email_update_failed" class="lp_msg_error"><?php echo __('Etwas ist schief gelaufen. Bitte versuche es erneut.', 'listeo'); ?></div>
			    	<div id="listing_claim_error" class="lp_msg_error"><?php echo __('Etwas ist schief gelaufen. Bitte versuche es erneut.', 'listeo'); ?></div>
			    	<div id="listing_blank_error" class="lp_msg_error"><?php echo __('Ungültige E-Mail-Adresse. Bitte prüfen und erneut versuchen.', 'listeo'); ?></div>
	    		</form>
			</div>
			<div class="clearfix"></div>
			</div>
		</div>
		<?php
		if($email_description!=""){ ?>
		<div class="wpb_text_column wpb_content_element email_description_content" style="<?php echo (!$show_btn)?'display:none':''; ?>">
			<div class="wpb_wrapper">
				<p><?php echo $email_description; ?></p>
			</div>
		</div>
		<?php } ?>
		<?php
		return ob_get_clean();
}
