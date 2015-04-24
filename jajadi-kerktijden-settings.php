<?php
//on activation set default style
register_activation_hook( __FILE__, 'set_up_options' );

function set_up_options(){
	update_option('jajadikerktijdenpasttext', '#a4a4a4');
	update_option('jajadikerktijdenpastdaytext', '#7a7a7a');
}




// create custom plugin settings menu
add_action('admin_menu', 'jajadi_kerktijden_settings_menu');

function jajadi_kerktijden_settings_menu() {

	//create new top-level menu
	add_options_page('Kerktijden', 'Kerktijden', 'manage_options', __FILE__, 'jajadi_kerktijden_settings_page');

	//call register settings function
	add_action( 'admin_init', 'jajadi_register_kerktijden_settings' );
}


function jajadi_register_kerktijden_settings() {
	//register our settings
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenkerkid' );
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdendefaulttext' );		// #023395 Default text.			Class: .emgKerktijdenGatherings.grootKerkDetail
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdendefaulbackground' );	// #FFFFFF Default backgrond.	Class: .emgKerktijdenGatherings.grootKerkDetail .gatherings
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdencancelledregular' );	// #a22b01 Cancelled regular		Class: .emgKerktijdenGatherings.grootKerkDetail .gathering.cancelled, .emgKerktijdenGatherings.grootKerkDetail .gathering.cancelled .type.regular
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdencancelledtype' );		// #a22b01 Cancelled type		Class: .emgKerktijdenGatherings.grootKerkDetail .gathering.cancelled .type
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdensermontyperegular' );	// #a7b8db Sermon type regular	Class: .emgKerktijdenGatherings.grootKerkDetail .gathering .type.regular
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenlink' );				// #023395 Link color			Class: .emgKerktijdenGatherings.grootKerkDetail .gatherings a
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenlinkhover' );			// #a22b01 Link Hover			Class: .emgKerktijdenGatherings.grootKerkDetail .gatherings a:hover
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdendate' );				// #a22b01 Date					Class: .emgKerktijdenGatherings.grootKerkDetail .month .dayText
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenlocation' );			// #5e7dbc Location				Class: .emgKerktijdenGatherings.grootKerkDetail .gathering .info .location
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenlocationdeviating' );	// #c4785d Location deviating	Class: .emgKerktijdenGatherings.grootKerkDetail .gathering .info .deviatingLocation 
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdensermontype' );			// #5e7dbc Sermon type			Class: .emgKerktijdenGatherings.grootKerkDetail .gathering .type
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenpasttext' );			// #a4a4a4 Past					Class: .emgKerktijdenGatherings.grootKerkDetail .month .day.past,
																							//								.emgKerktijdenGatherings.grootKerkDetail .month .day.past a,
																							//								.emgKerktijdenGatherings.grootKerkDetail .month .day.past .gathering .type,
																							//								.emgKerktijdenGatherings.grootKerkDetail .month .day.past .gathering .location,
																							//								.emgKerktijdenGatherings.grootKerkDetail .month .day.past .gathering .preacher
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerktijdenpastdaytext' );		// #7a7a7a Past Day text			Class: .emgKerktijdenGatherings.grootKerkDetail .month .day.past .dayText
		 
}



function jajadi_kerktijden_admin_tabs( $current = 'homepage' ) {
    $tabs = array( 'general' => __('General Settings', 'jajadi-kerktijden'));
	$tabs['style'] = __('Styling', 'jajadi-kerktijden');
	$tabs['about'] = __('About', 'jajadi-kerktijden');
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=jajadi-kerktijden/jajadi-kerktijden-settings.php&tab=$tab'>$name</a>";

    }
}

function jajadi_kerktijden_settings_page() {
	?>
	<div id="icon-options-general" class="icon32"></div><h2><?php echo __('Kerktijden', 'jajadi-kerktijden'); ?></h2>
	<h2 class="nav-tab-wrapper">
	<div class="wrap">
	<?php
	if ( isset ( $_GET['tab'] ) ){
		jajadi_kerktijden_admin_tabs($_GET['tab']);
		$tab = $_GET['tab'];
	}
	else{
		jajadi_kerktijden_admin_tabs('general');
		$tab = 'general';
	}
	?>
	</h2>

	<form method="post" action="options.php">
		<?php settings_fields( 'jajadi-kerktijden-settings' ); ?>
		<?php do_settings_sections( 'jajadi-kerktijden-settings' ); ?>
		<?php
		if($tab == 'general'){
			?>
			<table class="form-table">
				<tr valign="top">
				<th scope="row"><?php echo __('Church ID', 'jajadi-kerktijden'); ?>: </th>
				<td><input type="text" name="jajadikerktijdenkerkid" value="<?php echo get_option( 'jajadikerktijdenkerkid' ); ?>" /></td>
				</tr>
			</table><br />
			<input type="hidden" name="jajadikerktijdendefaulttext" value="<?php echo get_option( 'jajadikerktijdendefaulttext' ); ?>" />
			<input type="hidden" name="jajadikerktijdendefaulbackground" value="<?php echo get_option( 'jajadikerktijdendefaulbackground' ); ?>" />
			<input type="hidden" name="jajadikerktijdencancelledregular" value="<?php echo get_option( 'jajadikerktijdencancelledregular' ); ?>" />
			<input type="hidden" name="jajadikerktijdencancelledtype" value="<?php echo get_option( 'jajadikerktijdencancelledtype' ); ?>" />
			<input type="hidden" name="jajadikerktijdensermontyperegular" value="<?php echo get_option( 'jajadikerktijdensermontyperegular' ); ?>" />
			<input type="hidden" name="jajadikerktijdenlink" value="<?php echo get_option( 'jajadikerktijdenlink' ); ?>" />
			<input type="hidden" name="jajadikerktijdenlinkhover" value="<?php echo get_option( 'jajadikerktijdenlinkhover' ); ?>" />
			<input type="hidden" name="jajadikerktijdendate" value="<?php echo get_option( 'jajadikerktijdendate' ); ?>" />
			<input type="hidden" name="jajadikerktijdenlocation" value="<?php echo get_option( 'jajadikerktijdenlocation' ); ?>" />
			<input type="hidden" name="jajadikerktijdenlocationdeviating" value="<?php echo get_option( 'jajadikerktijdenlocationdeviating' ); ?>" />
			<input type="hidden" name="jajadikerktijdensermontype" value="<?php echo get_option( 'jajadikerktijdensermontype' ); ?>" />
			<input type="hidden" name="jajadikerktijdenpasttext" value="<?php echo get_option( 'jajadikerktijdenpasttext' ); ?>" />
			<input type="hidden" name="jajadikerktijdenpastdaytext" value="<?php echo get_option( 'jajadikerktijdenpastdaytext' ); ?>" />

		<?php
					submit_button(); 

		echo sprintf(__('Shortcode: %1$s', 'jajadi-kerktijden'), '[kerktijden]').'<br />';
		echo '<h2>' . __('Example', 'jajadi-kerktijden') . '</h2>';
		echo jajadi_kerktijden_shortcode();
		}
		elseif($tab == 'style'){
			include( plugin_dir_path( __FILE__ ) . 'jajadi-kerktijden-settings-style.php');
		}
		elseif($tab == 'about'){
			include( plugin_dir_path( __FILE__ ) . 'jajadi-kerktijden-about.php');
		}
		?>
		
		<?php 
		if($tab != 'about'){
			submit_button(); 
		}
			?>

	</form>
	</div>
	<?php
}
 
 ?>