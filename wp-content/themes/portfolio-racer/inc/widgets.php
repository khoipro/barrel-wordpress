<?php 


/* 
	Widgetized Areas
*/

register_sidebar(array(
	'name' => 'header-area',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'sidebar',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'margin',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));

register_sidebar(array(
	'name' => 'footer-column-1',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'footer-column-2',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'footer-column-3',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'footer-main',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));
register_sidebar(array(
	'name' => 'footer-margin',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title"><span>',
	'after_title' => '</span></h4>',
));

function show_widget_area($id) {	
	if (!sidebar_not_empty($id))
		return;
		
	print '<section id="'.$id.'">';
	dynamic_sidebar($id);
	print '</section> <!-- '.$id.' -->';
}

function sidebar_not_empty($name) {
	global $wp_registered_sidebars;
	
	foreach ((array)$wp_registered_sidebars as $s_id => $s_info)
		$sidebar_ids[$s_info['name']] = $s_id;
	
	$sidebars = wp_get_sidebars_widgets();
 
	if ($sidebars[$sidebar_ids[$name]])
		return true;
	else
		return false;
}

?>