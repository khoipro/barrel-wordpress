<?php

require_once('inc/category-root.php'); // Strip the word "category" from URL for category archives
require_once('inc/widgets.php'); // Define sidebars
require_once('inc/update.php'); // Include automatic updater


/* 
	CSS & JS	
*/

// Create custom style sheet, which will overwrite the existing one.
if (is_admin() && !file_exists(dirname(__FILE__). '/style-custom.css')) {
	$create_custom_css = fopen(dirname(__FILE__) . '/style-custom.css', 'w', true);
	fclose($create_custom_css);
}

if (!is_admin()) {
	// Add user facing javascript
	wp_enqueue_script('jquery');
	wp_enqueue_script('gallery-browser', get_template_directory_uri() . '/js/gallery-browser.js', array('jquery'), null, true);
	wp_enqueue_script('jquery-elastic', get_template_directory_uri() . '/js/jquery.elastic.js', array('jquery'), null, true);
	wp_enqueue_script('racer-js', get_template_directory_uri() . '/js/default.js', array('jquery', 'jquery-elastic'), null, true);
	
	// Add CSS
	wp_enqueue_style('portfolio-racer-css', get_bloginfo('stylesheet_directory') . '/style.css');
	
	// Add custom CSS
	if (file_exists(dirname(__FILE__). '/style-custom.css'))
		wp_enqueue_style('portfolio-racer-css-custom', get_template_directory_uri() . '/style-custom.css');	
}


/* 
	Gallery Browser
*/

// Enable adding type="browser" to [gallery] shortcode
add_action('admin_enqueue_scripts', 'add_gallery_type_browser');
function add_gallery_type_browser($where) {
	if ($where == 'media-upload-popup')
		wp_enqueue_script('gallery-browser-admin', get_template_directory_uri() . '/js/gallery-admin.js', array('jquery', 'media'));
}

//add_filter('post_gallery', 'no_gallery');
function no_gallery($attr) {
	// Run this only if is gallery type == browser
	print_r($attr.' + ');
	
	if (empty($attr['type']))
		return '';
}

//remove_shortcode('gallery');
add_shortcode('gallery', 'dot_gallery_shortcode');
function dot_gallery_shortcode($attr) {
	global $post;
		
	// Run this only if is gallery type == browser
	if (empty($attr['type']))
		return gallery_shortcode($attr);
	
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order',
		'id'         => $post->ID,
		'size'		 => 'large',
		'include'	 => '',
		'type'	 	 => ''
	), $attr));
	
	$id = intval($id);
	$cargs = array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby);
	
	if (!empty($include)) {
		$include = preg_replace( '/[^0-9,]+/', ' ', $include );
		
		$cargs['include'] = $include;
		$_attachments = get_posts($cargs);
		
		$attachments = array();
		foreach ( $_attachments as $key => $val )
			$attachments[$val->ID] = $_attachments[$key];
	} else {
		$attachments = get_children($cargs);
	}

	$output = "<div class='gallery-browser gallery-browser-id-{$id}'>";
	foreach ( $attachments as $id => $attachment ) {
		$output .= wp_get_attachment_image($id, $size, false, false); //wp_get_attachment_link($id, $size, false, false);
	}
	$output .= "</div>\n";

	return $output;
}


add_filter('body_class', 'alter_body_class');
function alter_body_class($classes) {
	global $is_safari, $is_iphone;
	
	if ($is_safari || $is_iphone) 
		$classes[] = 'is-webkit';
	
	return $classes;
}

function get_neighbour_links() {
	$page_walk = array();
	$active_pages = array_values(get_pages('sort_column=menu_order&sort_order=asc&hierarchical=1'));  
	$current_page = get_the_ID();
	
	foreach ($active_pages as $pid => $pdata) {
		if ($current_page == $pdata->ID) {
			$prev_id = $pid - 1;
			$next_id = $pid + 1;
			
			if ($active_pages[$prev_id] > -1) {
				$meta_title = get_post_meta($active_pages[$prev_id]->ID, 'title', true);
				if ($meta_title != '') $title = $meta_title; 
					else $title = $active_pages[$prev_id]->post_title;
					
				$page_walk['prev'] = '<a href="'. clean_url(get_permalink($active_pages[$prev_id]->ID)) .'" title="'. $title .'">'. wptexturize($title) .'</a>';
			}
			
			if ($active_pages[$next_id]->ID > -1) {
				$meta_title = get_post_meta($active_pages[$next_id]->ID, 'title', true);
				if ($meta_title != '') $title = $meta_title; 
					else $title = $active_pages[$next_id]->post_title;
					
				$page_walk['next'] = '<a href="'. clean_url(get_permalink($active_pages[$next_id]->ID)) .'" title="'. $title .'">'. wptexturize($title) .'</a>';
			}
		}
	}	
	
	return $page_walk;
}


// Add non-breaking space at the end of the array
add_filter('the_title', 'typofy_title');
function typofy_title($title) {
	$title = esc_attr(wptexturize($title));
	$title_parts = split("[\n\r\t ]+", $title);
	if (count($title_parts) > 2) {
		$last_word = array_pop($title_parts);
		if (strlen($title_parts[count($title_parts) - 1] . $last_word) > 5) {
			return implode(' ', $title_parts) . '&nbsp;' . $last_word;
		} else {
			$last_word = array_pop($title_parts) . '&nbsp;' . $last_word;
			return implode(' ', $title_parts) . '&nbsp;' . $last_word;
		}
	}
	return $title;
}

function get_sec_title() {
	$sec_title = apply_filters('sec_title', false);
	if ($sec_title !== false)
		return $sec_title;
	
	if (!is_single() && !is_page()) {
		$sec_title_pre = '<h4 class="sec-title">';
		$sec_title_suf = '</h4>';
	}
		
	if (is_category())
		$sec_title = '<strong>'. single_cat_title(null, false) .'</strong>';
	elseif (is_tag())
		$sec_title = '<strong>'. single_tag_title(null, false) .'</strong>';
	elseif (is_archive())
		$sec_title = '<strong>Archive</strong>';
		
	if (is_home() && $paged < 2 && !is_404())
		$sec_title .= ' <strong>Latest Entries</strong>';
	
	if (is_home() && $paged > 1 && !is_404())
		$sec_title .= ' <strong>Archive</strong>';
	
	if ($paged > 0 && !is_404())
		$sec_title .= ' <em>Page '. $paged .'</em>';
	elseif (!is_home() && !is_404())
		$sec_title .= ' <em>Latest Entries</em>';
	
	if (!empty($sec_title))
		echo $sec_title_pre . $sec_title . $sec_title_suf;
}


/*
	Allow filtering title seperator
*/

function filter_title_sep($sep) {
	return $sep;
}


/*
	Make friendly title tag 
*/

add_filter('wp_title', 'make_title_friendly', 10, 2);
function make_title_friendly($title, $sep) {
	global $paged, $post;
	
	$title = wptexturize($title);
	$sep = apply_filters('filter_title_sep', '&mdash;');
	
	if (is_single() || is_page()) { // Check if something else is not used for <title> tag
		if (strlen(get_post_meta($post->ID, 'title', true)) > 3)
			$title = get_post_meta($post->ID, 'title', true) . ' ' . $sep;
	}
	
	if (is_single()) // Add tags and categories after page title
		$title = ' ' . add_keywords_to_title($title, $sep);
	
	if (is_front_page())
		$title = get_bloginfo('title') . ' ' . $sep . ' ' . get_bloginfo('description');
	elseif (!is_feed()) // Amend blog title to every page
		$title .= ' ' . get_bloginfo('title');

	if ($paged > 1) // Add page number to avoid duplicate title
		$title .= ' (page ' . $paged . ')';

	return $title;
}

function add_keywords_to_title($title, $sep) {
	global $wp_query, $post;
	
	if (!is_page() && !is_attachment()) {
		$wp_query->in_the_loop = true;
		$this_id = $wp_query->post->ID;
		$parent_id = $wp_query->post->post_parent;
		$post_tags = array_merge(array_values((array)get_the_category()), array_values((array)get_the_tags()));
		if (count($post_tags) > 0 && is_array($post_tags) && !empty($post_tags[0])) {
			$tmp_title = strtolower($title);
			foreach($post_tags as $tid => $tagdata) {
				if (!empty($tagdata->name)) {
					if (strpos($tmp_title, strtolower($tagdata->name)) === false) {
						$tags .= ucfirst($tagdata->name) . ', ';
						$tmp_title .= ' ' . strtolower($tagdata->name);
					}
				}
			}
			if (!empty($tags)) 
				$title .= ' ' . substr($tags, 0, -2) . ' ' . $sep . ' ';
		}
	}
	
	return $title;
}

// Allow custom functions.php
if (is_admin() && !file_exists(dirname(__FILE__). '/functions-custom.php')) {
	$create_custom_css = fopen(dirname(__FILE__) . '/functions-custom.php', 'w', true);
	fclose($create_custom_css);
} else {
	@require_once('functions-custom.php');
}

?>