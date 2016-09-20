
jQuery(document).ready(function(){
	do_gallery();
});

function do_gallery() {
jQuery('.gallery-browser').each(function(i) {
	var $nav_items = '', $nav_item_class = '', $current_gallery = i, $this_gallery = this, $img_no, $scrolled = new Array();
	
	if (jQuery('img', this).size() < 2 || jQuery(this).hasClass('is-active'))
		return;
	else
		jQuery(this).addClass('is-active');
	
	jQuery(this).hover(function() {
		//jQuery('.agn-caption', $this_gallery).show();
	}, function() {
		//jQuery('.agn-caption', $this_gallery).hide();
	});
	
	jQuery('img', this).each(function(i) {
		$img_no = i + 1;
		
		jQuery(this).attr('id', 'agn-gallery-' + $current_gallery + '-item-' + $img_no);
		
		if (i > 0) {
			jQuery(this).css('display', 'none');
			$nav_item_class = '';
		} else {
			$nav_item_class = 'active';
			if (jQuery(this).height() > 0)
				jQuery($this_gallery).height(jQuery(this).height() + 'px');
		}
		
		$nav_items += '<li class="'+ $nav_item_class +'"><a href="#agn-gallery-' + $current_gallery + '-item-'+ $img_no +'">'+ $img_no +'</a></li> ';
	});
	
	$nav_items = '<div class="agn-nav">'
		+ '<span><a class="agn-prev disabled">&laquo; Previous</a> / <a href="#agn-gallery-' + $current_gallery + '-item-2" class="agn-next">Next &raquo;</a></span>' 
		+ '<div class="agn-items">'
		+ '<span>(<em>1</em> of '+ $img_no +')</span>'
		+ '<ul>' + $nav_items + '</ul>'
		+ '</div>';
	
	jQuery(this).attr('id', 'agn-gallery-' + $current_gallery).prepend($nav_items);
	jQuery(this).append('<p class="agn-caption" id="agn-' + $current_gallery + '-caption" style="display:none;"></p>');
	
	set_gallery_caption($current_gallery, 1);
	
	jQuery('.agn-nav a', this).click(function(event) {
		event.preventDefault();
		
		var $a_href = jQuery(this).attr('href');
		
		if (typeof($a_href) == 'undefined')
			return;
		
		// Show image
		show_image(this, $a_href.replace('#', ''));
		
		// Scroll window to top, so that most of images can be seen
		var $gal_id = $a_href.split('-')[2];
		if (!$scrolled[$gal_id]) {
			jQuery('html, body').animate({ scrollTop: (jQuery(this).offset().top - 50) }, 'slow');
			$scrolled[$gal_id] = true;
		}
	});
	
	function show_image($a_obj, $show_image_id) {
		var $gal_id = parseInt($show_image_id.split('-')[2]);
		var $img_id = parseInt($show_image_id.split('-')[4]);
		
		// Clicked on the last one
		if ($img_id == $img_no)
			jQuery('#agn-gallery-' + $gal_id + ' a.agn-next').removeAttr('href').addClass('disabled');
		
		// Clicked on the first one
		if ($img_id == 1)
			jQuery('#agn-gallery-' + $gal_id + ' a.agn-prev').removeAttr('href').addClass('disabled');
		
		if ($img_id > 1 && $img_id <= $img_no)
			jQuery('#agn-gallery-' + $gal_id + ' a.agn-prev').attr('href', '#agn-gallery-' + $gal_id + '-item-' + parseInt($img_id - 1)).removeClass('disabled');
		
		if ($img_id < $img_no && $img_id > 0)
			jQuery('#agn-gallery-' + $gal_id + ' a.agn-next').attr('href', '#agn-gallery-' + $gal_id + '-item-' + parseInt($img_id + 1)).removeClass('disabled');
		
		// Change the active image number
		jQuery('#agn-gallery-' + $gal_id + ' span em').text($img_id);
		
		// Set new active nav item
		var temp = $img_id - 1;
		jQuery('#agn-gallery-' + $gal_id + ' li').siblings('li').attr('class', '');
		jQuery('#agn-gallery-' + $gal_id + ' li:eq(' + temp + ')').addClass('active');
		
		// Show the new image and hide the rest
		jQuery('img#'+$show_image_id).css('z-index', 250).fadeIn('fast').siblings('img').css('z-index', 5).fadeOut('fast');
		
		// Adjust gallery height
		jQuery('#agn-gallery-' + $gal_id).animate({'height': jQuery('img#'+$show_image_id).height() + 'px'}, 'fast');
		
		// Set caption
		set_gallery_caption($gal_id, $img_id);
	}
	
	
	function set_gallery_caption($gal_id, $image_id) {
		//#agn-gallery-' + $current_gallery + '-item-'+ $img_no +'
		var $new_image_caption = jQuery('img#agn-gallery-'+$gal_id+'-item-'+$image_id).attr('title');
		
		if ($new_image_caption.length < 2)
			$new_image_caption = '';
			
		jQuery('#agn-'+$gal_id+'-caption').text($new_image_caption);
	}
});

}