<?php
$age = get_post_meta($post->ID, 'lp-age-content', true);
$gender = get_post_meta($post->ID, 'lp-gender-content', true);
$ethnicity = get_post_meta($post->ID, 'lp-ethnicity-content', true);
$height = get_post_meta($post->ID, 'lp-height-content', true);
$hair = get_post_meta($post->ID, 'lp-hair-content', true);
$eyes = get_post_meta($post->ID, 'lp-eyes-content', true);
$body = get_post_meta($post->ID, 'lp-body-content', true);
$boobs = get_post_meta($post->ID, 'lp-boobs-content', true);
$boobs_size = get_post_meta($post->ID, 'lp-boobs-size-content', true);
$intim = get_post_meta($post->ID, 'lp-intim-content', true);
$skin = get_post_meta($post->ID, 'lp-skin-content', true);
$body_dekort = get_post_meta($post->ID, 'lp-body-dekort-content', true);
$language = get_post_meta($post->ID, 'lp-language-content', true);
$language_display = $body_dekort_display = "";

if(!empty($language))
	$language_display = implode(", ", $language);

if(!empty($body_dekort))
	$body_dekort_display = implode(", ", $body_dekort);

$is_data_available = false;
?>
<div id="listing-personal-data" class="listing-section">
	<h3 class="listing-desc-headline" style="margin-top: 0px;"><?php esc_html_e('Personal Data','listeo-extra-fields'); ?></h3>
	<div class="pricing-list-container">
		<ul class="pricing-menu-no-title">
			<?php 
			if($age!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Age', 'listeo-extra-fields'); ?></b> <span><?php echo $age; ?></span></p></li>
			<?php } ?>
		
			<?php 
			if($gender!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Gender', 'listeo-extra-fields'); ?></b> <span><?php echo $gender; ?></span></p></li>
			<?php } ?>
		
			<?php 
			if($ethnicity!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Ethnicity', 'listeo-extra-fields'); ?></b> <span><?php echo $ethnicity; ?></span></p></li>
			<?php } ?>

			<?php 
			if($height!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Height', 'listeo-extra-fields'); ?></b> <span><?php echo $height; ?> <?php _e('CM', 'listeo')?></span></p></li>
			<?php } ?>

			<?php 
			if($hair!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Hair', 'listeo-extra-fields'); ?></b> <span><?php echo $hair; ?></span></p></li>
			<?php } ?>

			<?php 
			if($eyes!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Eyes', 'listeo-extra-fields'); ?></b> <span><?php echo $eyes; ?></span></p></li>
			<?php } ?>

			<?php 
			if($body!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Body', 'listeo-extra-fields'); ?></b> <span><?php echo $body; ?></span></p></li>
			<?php } ?>

			<?php 
			if($boobs!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Boobs', 'listeo-extra-fields'); ?></b> <span><?php echo $boobs; ?></span></p></li>
			<?php } ?>

			<?php 
			if($boobs_size!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Boobs Size', 'listeo-extra-fields'); ?></b> <span><?php echo $boobs_size; ?></span></p></li>
			<?php } ?>

			<?php 
			if($intim!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Intim', 'listeo-extra-fields'); ?></b> <span><?php echo $intim; ?></span></p></li>
			<?php } ?>

			<?php 
			if($skin!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Skin', 'listeo-extra-fields'); ?></b> <span><?php echo $skin; ?></span></p></li>
			<?php } ?>

			<?php 
			if($body_dekort_display!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Body Dekort', 'listeo-extra-fields'); ?></b> <span><?php echo $body_dekort_display; ?></span></p></li>
			<?php } ?>

			<?php 
			if($language_display!=""){ 
				$is_data_available = true;
				?>
				<li><p><b><?php _e('Languages', 'listeo-extra-fields'); ?></b> <span><?php echo $language_display; ?></span></p></li>
			<?php } ?>

			<?php
			if(!$is_data_available){ ?>
				<li><p style="text-align: center;"><b><?php _e('No data available.', 'listeo-extra-fields'); ?></b></p></li>
			<?php } ?>
		</ul>
	</div>	
</div>