<?php

function jajadi_kerktijden_load_textdomain() {
	load_plugin_textdomain( 'jajadi-kerktijden', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}



/********************************************************************************************************/
/*	returns the content of $GLOBALS['post']																*/
/*	Function updated by henrivanwerkhoven [https://wordpress.org/support/profile/henrivanwerkhoven]		*/
/********************************************************************************************************/
function jajadi_kerktijden_shortcode($atts){
	// default attributes
	$atts = shortcode_atts( array(
		'limit' => NULL, /* number of items to show, NULL to show all */
		'narrow' => FALSE, /* set to TRUE to display in narrow style (i.e. pastor on second line) */
 		'future_only' => FALSE, /* set to TRUE to show only future sermons */
		'url' => NULL, /* url to page containing all sermons, NULL to omit url */
		'url_name' => 'more sermons' /* name for urlto page containing all sermons */
	), $atts);
	// original code
	$return				= '';
	$kerktijdensite		= 'http://www.kerktijden.nl/gem/' . get_option( 'jajadikerkid' );
	$ch					= curl_init ($kerktijdensite);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$page				= curl_exec($ch);

	preg_match('#<ul class="gatherings" id="gatherings"[^>]*>(.+?)</ul><div#is', $page, $matches);
	foreach ($matches as &$match) {
		$match = $match;
	}
	if(!is_null($atts['limit']) || $atts['future_only']){
		/* added functionality:
		 *   optionally limit number of sermons displayed
		 *   optionally only show future sermons
		 *   optionally display in narrow layout (pastor on second line) [requires limit or future_only to be set]
		 *   optionally add a link to all sermons [requires limit or future_only to be set]
		 */
		$table = '';
		$lines = preg_split('#</tr>#is', $matches[1]);
		$c = 0;
		for($i=1; $i<count($lines); $i++){
			if($atts['future_only'] && preg_match('#style="color: gray;"#is',$lines[$i])) continue;
			if($atts['narrow']){
				preg_match_all('#<td[^>]*>(.*?)</td>#is',$lines[$i], $cellmatches);
				$cells = $cellmatches[1];
				$table .= '<tr class="list_tr"><td class="td_left">'. str_replace(" uur","",$cells[0]) . (empty($cells[2]) ? '' : ' ('.$cells[2].')') . '<br/><em>' . $cells[1] . '</em></td></tr>';
			}
			else{
				$table .= $lines[$i] . '</tr>';
			}
			$c ++;
			if(!is_null($atts['limit']) && $c == $atts['limit']) break;
		}
		$table .= '<tr><td' . ($atts['narrow'] ? '' : ' colspan="3"') . '>';
		if(!is_null($atts['url'])){
			$table .= '<a href="' . htmlspecialchars($atts['url']) . '" style="float:right;">' . htmlspecialchars($atts['url_name']) . '</a>';
		}
		$table .= '<small>' . __('Source:', 'jajadi-kerktijden') . ' <a href="http://www.kerktijden.nl/">kerktijden.nl</a></small></td></tr>';
		return '<table style="border:none;">' . $table . '</table>';
	}
	$return	.= '<table class="jajadikerktijden">';
	$return	.= $matches[1];
	$return	.= '</table><br /><small>' . __('Source:', 'jajadi-kerktijden') . ' <a href="http://www.kerktijden.nl/gem/' . get_option( 'jajadikerkid' ) . '">kerktijden.nl</a></small>';
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