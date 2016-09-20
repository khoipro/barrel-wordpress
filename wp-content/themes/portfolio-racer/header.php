<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title('&mdash;', true, 'right'); ?></title>
	<?php if ((is_archive() || $paged > 0) && !is_category()): ?>
	<meta name="robots" content="noindex, follow" />
	<?php endif; ?>
	<?php wp_head(); ?>
	<!--[if lte IE 8]><script src="<?php print get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script><![endif]-->
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--<link rel="shortcut icon" type="image/x-icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />-->
</head>
<body <?php body_class(); ?>>
<div id="soul">

<header id="header">
	<p id="logo">
		<a href="<?php bloginfo('home'); ?>/"><strong><?php bloginfo('name'); ?></strong></a>
		<em><?php bloginfo('description'); ?></em>
	</p>
	
	<nav id="nav-main">
		<?php wp_page_menu('title_li=&show_home=Index'); ?>
	</nav>	
</header>

<section id="content-main"><div class="in">

<?php show_widget_area('header-area'); ?>
