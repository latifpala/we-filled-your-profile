<?php
add_shortcode( 'profile_listing', 'show_profile_listing' );
function show_profile_listing( $atts = array() ) {
		extract( $atts = shortcode_atts( array(
			'btn_title'					=> 'Profil zeigen', //grid, grid-compact
		), $atts ) );
		$listing_id_error = false;
		if(isset($_SESSION['listing_id'])){
			if($_SESSION['listing_id']==0){
				$listing_id_error = true;
			}else{
				$listing_id_error = false;
				$listing_id = $_SESSION['listing_id'];
			}
		}else{
			$listing_id_error = true;
		}
		if($listing_id_error){
			ob_start(); ?>
			<div class="col-lg-12 col-md-12">
				<div class="listing-item-container listing-geo-data  list-layout">
					Invalid Profile Data
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
		$args = array(
		  'p'         => $listing_id, // ID of a page, post, or custom type
		  'post_type' => 'listing',
		  'post_status' => array('preview', 'trash', 'publish', 'expired', 'draft', 'pending_payment')
		);
		$listing_post = new WP_Query($args);
		ob_start();
		if($listing_post->have_posts()):
			while($listing_post->have_posts()):
				$listing_post->the_post();
				$listing_type = get_post_meta(get_the_ID(), '_listing_type', true);
				$listing_hash_id = get_post_meta(get_the_ID(), 'md5_hash', true);
		?>
		<div class="col-lg-12 col-md-12">
			<div class="listing-item-container listing-geo-data  list-layout <?php echo esc_attr('listing-type-'.$listing_type) ?>" <?php echo listeo_get_geo_data($listing_post); ?> >
				<a href="<?php echo site_url('listing-preview/').$listing_hash_id; ?>" class="listing-item">
					 <div class="listing-small-badges-container">
			        </div>
					<!-- Image -->
					<div class="listing-item-image">
						<?php
						
						if(has_post_thumbnail()){ 
							the_post_thumbnail('listeo-listing-grid'); 
						} else { 
							
							$gallery = (array) get_post_meta( get_the_ID(), '_gallery', true );

							$ids = array_keys($gallery);
							if(!empty($ids[0]) && $ids[0] !== 0){ 
								$image_url = wp_get_attachment_image_url($ids[0],'listeo-listing-grid'); 
							} else {
								$image_url = get_listeo_core_placeholder_image();
							}
							?>
							<img src="<?php echo esc_attr($image_url); ?>" alt="">
						<?php
						} ?>

						<?php $terms = get_the_terms( get_the_ID(), 'listing_category' );
								if ( $terms && ! is_wp_error( $terms ) ) : 
								    $categories = array();
								    foreach ( $terms as $term ) {
								        $categories[] = $term->name;
								    }

								    $categories_list = join( ", ", $categories );
								    ?>
								    <span class="tag">
								        <?php  esc_html_e( $categories_list ) ?>
								    </span>
								<?php endif; ?>
					</div>

					<!-- Content -->
					<div class="listing-item-content">
						<?php if( $listing_type  == 'service' && get_post_meta( get_the_ID(),'_opening_hours_status',true )) { 
				                if( listeo_check_if_open() ){ ?>
				                    <div class="listing-badge now-open"><?php esc_html_e('Now Open','listeo_core'); ?></div>
				                <?php } else { 
				                    if( listeo_check_if_has_hours() ) { ?>
				                        <div class="listing-badge now-closed"><?php esc_html_e('Now Closed','listeo_core'); ?></div>
				                    <?php } ?>
				            <?php } 
				        }?>
						<div class="listing-item-inner">
							<h3>
								<?php the_title(); ?> 
								<?php if( get_post_meta(get_the_ID(),'_verified',true ) == 'on') : ?><i class="verified-icon"></i><?php endif; ?>
							</h3>
							<span><?php the_listing_location_link(get_the_ID(), false); ?></span>
							
							<?php 
							if(!get_option('listeo_disable_reviews')){
								$rating = get_post_meta(get_the_ID(), 'listeo-avg-rating', true); 
								if(isset($rating) && $rating > 0 ) : 
									$rating_type = get_option('listeo_rating_type','star');
									if($rating_type == 'numerical') { ?>
										<div class="numerical-rating" data-rating="<?php $rating_value = esc_attr(round($rating,1)); printf("%0.1f",$rating_value); ?>">
									<?php } else { ?>
										<div class="star-rating" data-rating="<?php echo $rating; ?>">
									<?php } ?>
										<?php $number = listeo_get_reviews_number(get_the_ID());  ?>
										<div class="rating-counter">(<?php printf( _n( '%s review', '%s reviews', $number,'listeo_core' ), number_format_i18n( $number ) );  ?>)</div>
									</div>
							<?php endif; 
							}?>
							
						</div>
					</div>
				</a>
			</div>
		</div>
		<div class="vc_btn3-container vc_btn3-center">
			<a style="background-color:#5e0afa; color:#ffffff;" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-round vc_btn3-style-custom" href="<?php echo site_url('listing-preview/').$listing_hash_id; ?>" title="<?php echo $btn_title; ?>"><?php echo $btn_title; ?></a>
		</div>

		<?php
				endwhile;
			else:
			?>
			<div class="col-lg-12 col-md-12">
				<div class="listing-item-container listing-geo-data  list-layout">
					Invalid Profile Data
				</div>
			</div>
		<?php
			endif;
		return ob_get_clean();
}