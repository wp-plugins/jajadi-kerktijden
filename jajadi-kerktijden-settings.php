<?php
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
	register_setting( 'jajadi-kerktijden-settings', 'jajadikerkid' );
}

function jajadi_kerktijden_admin_tabs( $current = 'homepage' ) {
    $tabs = array( 'general' => __('General Settings', 'jajadi-kerktijden'));
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
				<td><input type="text" name="jajadikerkid" value="<?php echo get_option( 'jajadikerkid' ); ?>" /></td>
				</tr>
			</table><br />
		<?php
		echo sprintf(__('Shortcode: %1$s', 'jajadi-kerktijden'), '[kerktijden]').'<br />';
		
		$kerktijdensite = 'http://www.kerktijden.nl/?zoek=toonkerktijden&kerkid=' . get_option( 'jajadikerkid' );
		$ch = curl_init ($kerktijdensite);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$page = curl_exec($ch);
		
		preg_match('#<span class="pagina_titel">(.+?)</span>#is', $page, $matches);
		echo '<h3>';
			$string = array('<a href="?zoek=kerken&amp;kerkid='.get_option( 'jajadikerkid' ).'">','</a>');
			$empty = array('','');
			$church = str_replace($string,$empty,$matches[1]);
			echo $church;
		echo '</h3>';
		
		preg_match('#<table id="zoekresultaten"[^>]*>(.+?)</table>#is', $page, $matches);
		echo '<table>';
			echo $matches[1];
		echo '</table>';
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