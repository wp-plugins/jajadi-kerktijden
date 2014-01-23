<?php

function jajadi_kerktijden_load_textdomain() {
	load_plugin_textdomain( 'jajadi-kerktijden', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}



/************************************************************************************************/
/*	returns the content of $GLOBALS['post']														*/
/************************************************************************************************/
function jajadi_kerktijden_shortcode(){
	$return				= '';
	$kerktijdensite		= 'http://www.kerktijden.nl/?zoek=toonkerktijden&kerkid=' . get_option( 'jajadikerkid' );
	$ch					= curl_init ($kerktijdensite);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$page				= curl_exec($ch);

	preg_match('#<table id="zoekresultaten"[^>]*>(.+?)</table>#is', $page, $matches);
	foreach ($matches as &$match) {
		$match = $match;
	}
	$return	.= '<table class="jajadikerktijden">';
	$return	.= $matches[1];
	$return	.= '</table><br /><small>' . __('Source:', 'jajadi-kerktijden') . ' <a href="http://www.kerktijden.nl/">kerktijden.nl</a></small>';
	return $return;
}
add_shortcode('kerktijden', 'jajadi_kerktijden_shortcode');

/************************************************************************************************/
/*	Add settings link on plugin page															*/
/************************************************************************************************/
function jajadi_kerktijden_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=jajadi-kerktijden/jajadi-kerktijden-settings.php">' . __('Settings', 'jajadi-kerktijden') . '</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

/************************************************************************************************/
/*	Add Helptext															*/
/************************************************************************************************/
function jajadi_kerktijden_add_help_text( $contextual_help, $screen_id, $screen ) { 
	if ( 'settings_page_jajadi-kerktijden/jajadi-kerktijden-settings' == $screen->id ) {
		$contextual_help =
			'<p><strong>' . __('How to use this plugin', 'jajadi-kerktijden') . '</strong></p>' .
			'<ol type="1">' .
			'<li>' . sprintf(__('Go to %1$s and search your church.', 'jajadi-kerktijden'), '<a href="http://www.kerktijden.nl/">kerktijden.nl</a>') . '</li>' .
			'<li>' . sprintf(__('Look in the URL and search for the id. (Example: %1$s the id is %2$s)', 'jajadi-kerktijden'), 'http://www.kerktijden.nl/?zoek=kerken&kerkid=1', '1') . '</li>' .
			'<li>' . __('Insert the id below and hit save.', 'jajadi-kerktijden') . '</li>' .
			'<li>' . sprintf(__('Create a page or post and paste the following shortcode: %1$s', 'jajadi-kerktijden'), '[kerktijden]') . '</li>' .
			'</ol>';
	}
	return $contextual_help;
}



?>