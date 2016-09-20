jQuery(document).ready(function(){
	var $gallery_type_html = '<tr><th class="label" scrope="row"><label>Gallery Type</label></th>'
		+ '<td class="field">'
		+ '<label><input type="radio" value="type-thumbnails" id="gallery-type-thumbnails" name="gallery-type" /> Thumbnails</label>'
		+ '<label><input type="radio" value="type-browser" id="gallery-type-browser" name="gallery-type" /> Browser</label>'
		+ '</td></tr>';
	
	w = wpgallery.getWin();
	editor = w.tinymce.EditorManager.activeEditor;
	gal = editor.selection.getNode();
	
	if (editor.dom.hasClass(gal, 'wpGallery')) {
		var $is_update = true;
		jQuery('#basic tbody').prepend($gallery_type_html);
		
		// Check if gallery is with type="browser"
		gallery_type = editor.dom.getAttrib(gal, 'title').match(/type=['"]([^'"]+)['"]/i);
		if (gallery_type != null && gallery_type[1] == 'browser')
			jQuery('#gallery-type-browser').attr('checked', true);
			
	} else {
		var $is_update = false;
		// Add 'Insert Gallery Browser' button
		jQuery('#gallery-settings p.ml-submit').append('<input type="button" value="Insert gallery browser" id="insert-gallery-browser" name="insert-gallery-browser" class="button"/>');
	}		
	
	// Insert new gallery browser
	jQuery('#insert-gallery-browser').mousedown(function() {
		wpgallery.getWin().send_to_editor('[gallery'+wpgallery.getSettings()+' type="browser"]');
	});
	
	// Update the actual shortcode
	jQuery('#update-gallery, #save-all').mousedown(function() {
		var orig_gallery = editor.dom.decode(editor.dom.getAttrib(gal, 'title'));
		
		// If gallery type=browser didn't exist before, add it now
		if (jQuery('input#gallery-type-browser').is(':checked') && orig_gallery.indexOf(' type=') == -1)
			editor.dom.setAttrib(gal, 'title', orig_gallery + ' type="browser"');
		else
			editor.dom.setAttrib(gal, 'title', orig_gallery.replace(/type=['"]([^'"]+)['"]/i, ''));
	});	
});