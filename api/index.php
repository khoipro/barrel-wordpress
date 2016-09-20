<?php 

// Sample Plugin & Theme API by Kaspars Dambis (kaspars@konstruktors.com)

$packages['portfolio-racer'] = array(
	'versions' => array(
		'0.5' => array(
			'version' => '0.5',
			'date' => '2010-04-10',
			'package' => 'http://dev-barrel-base-theme.pantheonsite.io/api/themes/portfolio-racer/portfolio-racer-0.5.zip'
		)
	),
	'info' => array(
		'url' => 'http://portfolio.konstruktors.com/'
	)
);

$packages['test-plugin-update'] = array(
	'versions' => array(
		'0.5' => array(
			'version' => '0.5',
			'date' => '2010-04-10',
			'package' => 'http://dev-barrel-base-theme.pantheonsite.io/api/plugins/test-plugin-update/test-plugin-update.zip'
		)
	),
	'info' => array(
		'url' => 'http://konstruktors.com/plugins/test-plugin-update'
	)	
);



// Process API requests
if ( empty( $_POST['action'] ) || empty( $_POST['request'] ) ) {
	echo 0;
	exit;
}
$action = $_POST['action'];
$args = unserialize($_POST['request']);

if (is_array($args))
	$args = array_to_object($args);

$latest_package = array_shift($packages[$args->slug]['versions']);



// basic_check

if ($action == 'basic_check') {	
	$update_info = array_to_object($latest_package);
	$update_info->slug = $args->slug;
	
	if (version_compare($args->version, $latest_package['version'], '<'))
		$update_info->new_version = $update_info->version;
	
	print serialize($update_info);
}


// plugin_information

if ($action == 'plugin_information') {	
	$data = new stdClass;
	
	$data->slug = $args->slug;
	$data->version = $latest_package['version'];
	$data->last_updated = $latest_package['date'];
	$data->download_link = $latest_package['package'];
	
	$data->sections = array('description' => '<h2>$_POST</h2><small><pre>'.var_export($_POST, true).'</pre></small>'
		. '<h2>Response</h2><small><pre>'.var_export($data, true).'</pre></small>'
		. '<h2>Packages</h2><small><pre>'.var_export($packages, true).'</pre></small>');

	print serialize($data);
}


// theme_update

if ($action == 'theme_update') {
	$update_info = array_to_object($latest_package);
	
	//$update_data = new stdClass;
	$update_data = array();
	$update_data['package'] = $update_info->package;	
	$update_data['new_version'] = $update_info->version;
	$update_data['url'] = $packages[$args->slug]['info']['url'];
		
	if (version_compare($args->version, $latest_package['version'], '<'))
		print serialize($update_data);	
}



function array_to_object($array = array()) {
    if (empty($array) || !is_array($array))
		return false;
		
	$data = new stdClass;
    foreach ($array as $akey => $aval)
            $data->{$akey} = $aval;
	return $data;
}

?>
