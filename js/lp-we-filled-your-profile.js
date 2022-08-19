(function ($) {
	$('#lp_publish_listing_btn').click(function(e){
		e.preventDefault();
		$(this).html('Please wait..');
		var listing_id = $('#lp_listing_id').val();
		jQuery.ajax({
			type: "POST",
			url: listeo_core.ajax_url,
			data: {
				action: 'lp_update_listing_status', 
				listing_id: listing_id
			}, 
			success: function(response){
				if(response=="success"){
					$('#listing_claim_success').show();
					$('#listing_claim_error').hide();

					$('#lp_publish_listing_wrapper').hide();
					$('#lp_email_field_wrapper').show();

					$('.email_description_content').hide();

				}else{
					$('#listing_claim_error').show();
					$('#listing_claim_success').hide();
				}
			}
		});
	});

	$('#lp_email_field_btn').click(function(e){
		e.preventDefault();
		var old_title = $(this).attr('title');

		$('#listing_claim_success').hide();
		$('#listing_claim_error').hide();
		var listing_id = $('#lp_listing_id').val();
		var emailid = $('#listing_claim_email').val();
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		var error = true;
		if(emailid!=""){
			if(!pattern.test(emailid)){
				$('#listing_blank_error').show();
			}else{
				error = false;
				$('#listing_blank_error').hide();
			}
		}else{
			$('#listing_blank_error').show();
		}
		if(!error){
			$('#lp_email_field_btn').html('Please wait...');

			jQuery.ajax({
				type: "POST",
				url: listeo_core.ajax_url,
				data: {
					action: 'lp_update_email', 
					listing_id: listing_id,
					emailid : emailid
				}, 
				success: function(response){
					$('#lp_email_field_btn').html(old_title);
					if(response == "email_exists"){
						$('#listing_blank_error').hide();
						$('#listing_email_update_failed').hide();
						$('#listing_email_update').hide();
						$('#listing_email_already_exists').show();
					}else if(response=="success"){
						$('#listing_blank_error').hide();
						$('#listing_email_update_failed').hide();
						$('#listing_email_update').show();
						$('#lp_email_field_wrapper').hide();
						$('#listing_email_already_exists').hide();
					}else{
						$('#listing_blank_error').hide();
						$('#listing_email_update_failed').show();
						$('#listing_email_update').hide();
						$('#listing_email_already_exists').hide();
					}
				}
			});
		}

	});

	$('#lp_publish_listing_btn2').click(function(e){
		e.preventDefault();
		$(this).html('Please wait..');
		var listing_id = $('#lp_listing_id').val();
		var lp_listing_hash_id = $('#lp_listing_hash_id').val();
		var lp_add_listing_email_url = $('#lp_add_listing_email_url').val();
		jQuery.ajax({
			type: "POST",
			url: listeo_core.ajax_url,
			data: {
				action: 'lp_update_listing_status', 
				listing_id: listing_id
			}, 
			success: function(response){
				window.location.href = lp_add_listing_email_url;
			}
		});
	});

	/*$('#lp_email_field_btn').click(function(e){
		e.preventDefault();
		$('#listing_claim_success').hide();
		$('#listing_claim_error').hide();
		var listing_id = $('#lp_listing_id').val();
		var emailid = $('#listing_claim_email').val();
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		var error = true;
		if(emailid!=""){
			if(!pattern.test(emailid)){
				$('#listing_blank_error').show();
			}else{
				error = false;
				$('#listing_blank_error').hide();
			}
		}else{
			$('#listing_blank_error').show();
		}
		if(!error){
			jQuery.ajax({
				type: "POST",
				url: listeo_core.ajax_url,
				data: {
					action: 'lp_update_email', 
					listing_id: listing_id,
					emailid : emailid
				}, 
				success: function(response){
					if(response=="success"){
						$('#listing_blank_error').hide();
						$('#listing_email_update_failed').hide();
						$('#listing_email_update').show();
						$('#lp_email_field_wrapper').hide();
					}else{
						$('#listing_blank_error').hide();
						$('#listing_email_update_failed').show();
						$('#listing_email_update').hide();
					}
				}
			});
		}

	});*/
	$('.simple-listing-profile-slick-carousel').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		responsive: [
		{
		  breakpoint: 1610,
		  settings: {
			slidesToShow: 1,
		  }
		},
		{
		  breakpoint: 1365,
		  settings: {
			slidesToShow: 1,
		  }
		},
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 1,
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
			slidesToShow: 1,
		  }
		}
		]
	}).on("init", function(e, slick) {

		console.log(slick);
            //slideautplay = $('div[data-slick-index="'+ slick.currentSlide + '"]').data("time");
            //$s.slick("setOption", "autoplaySpeed", slideTime);
    });
})(jQuery);