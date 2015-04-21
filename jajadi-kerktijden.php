<?php
/*
	Plugin Name: JaJaDi Kerktijden.nl
	Plugin URI: http://tech.janjaapvandijk.nl/jajadi-kerktijden
	Description: Publish sermons from kerktijden.nl
	Version: 1.3
	Author: Janjaap van Dijk
	Author URI: http://tech.janjaapvandijk.nl
	License: GPL2
	Text Domain: jajadi-kerktijden
	Domain Path: /languages/
*/

/*	Copyright 2013  J. van Dijk 

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/************************************************************************************************/
/*	Algemene acties																				*/
/************************************************************************************************/

// Include other files
include( plugin_dir_path( __FILE__ ) . 'jajadi-kerktijden-settings.php');
include( plugin_dir_path( __FILE__ ) . 'jajadi-kerktijden-functions.php');
// Hooks a function on to a specific action.
add_action( 'plugins_loaded', 'jajadi_kerktijden_load_textdomain');
add_action( 'contextual_help', 'jajadi_kerktijden_add_help_text', 10, 3 );
?>