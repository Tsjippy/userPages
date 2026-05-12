<?php
namespace TSJIPPY\USERPAGES;
use TSJIPPY;

/**
 * Plugin Name:  		Tsjippy User Pages
 * Description:  		This plugin adds 3 shortcodes: <h4>all_contacts</h4> This shortcode displays a button to download all registered users to store them as contacts in gmail or outtlook. Use like this: <code>[all_contacts']</code> <h4>user-link</h4> This shortcode displays a user in a post or page. It has 5 properties: 'id' The id of the user to be displayed, mandatory 'picture' Whether the users picture should be displayed or not. 'phone' Whether the users phonenumbers should be displayed or not. 'email' Whether the users e-mail addresses should be displayed or not. 'style' Any additional html styling. Use like this: <code>[user-link id="12"]</code>
 * Version:      		10.0.7
 * Author:       		Ewald Harmsen
 * AuthorURI:			harmseninnigeria.nl
 * Requires at least:	6.3
 * Requires PHP: 		8.3
 * Tested up to: 		6.9
 * Plugin URI:			https://github.com/Tsjippy/userpages
 * Tested:				6.9
 * TextDomain:			tsjippy
 * Requires Plugins:	tsjippy-shared-functionality
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * @author Ewald Harmsen
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$pluginData = get_plugin_data(__FILE__, false, false);

// Define constants
define(__NAMESPACE__ .'\PLUGIN', plugin_basename(__FILE__));
define(__NAMESPACE__ .'\PLUGINPATH', __DIR__.'/');
define(__NAMESPACE__ .'\PLUGINVERSION', $pluginData['Version']);
define(__NAMESPACE__ .'\PLUGINSLUG', str_replace('tsjippy-', '', basename(__FILE__, '.php')));
define(__NAMESPACE__ .'\SETTINGS', get_option('tsjippy_'.PLUGINSLUG.'_settings', []));

// run right before activation
register_activation_hook( __FILE__, function(){
	// Create account page
	$settings	= SETTINGS;

	$settings['all-contacts-page']	= TSJIPPY\ADMIN\createDefaultPage('All Users', '[all_contacts]');

	update_option('tsjippy_'.PLUGINSLUG.'_settings', $settings);
} );

// run on deactivation
register_deactivation_hook( __FILE__, function(){
	foreach(SETTINGS['all-contacts-page'] as $page){
		// Remove the auto created page
		wp_delete_post($page, true);
	}
} );

