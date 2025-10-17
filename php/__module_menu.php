<?php
namespace SIM\USERPAGES;
use SIM;

const MODULE_VERSION		= '8.1.4';
//module slug is the same as grandparent folder name
DEFINE(__NAMESPACE__.'\MODULE_SLUG', strtolower(basename(dirname(__DIR__))));

DEFINE(__NAMESPACE__.'\MODULE_PATH', str_replace('\\', '/', plugin_dir_path(__DIR__)));

add_filter('sim_submenu_userpages_description', __NAMESPACE__.'\moduleDescription', 10, 2);
function moduleDescription($description, $moduleSlug){
	ob_start();
	$url		= SIM\ADMIN\getDefaultPageLink($moduleSlug, 'all-contacts-pages');
	if(!empty($url)){
		?>
		<p>
			<strong>Auto created page:</strong><br>
			<a href='<?php echo $url;?>'>User overview page</a><br>
		</p>
		<?php
	}
	return $description.ob_get_clean();
}

add_filter('sim_module_userpages_after_save', __NAMESPACE__.'\moduleUpdated', 10, 2);
function moduleUpdated($options, $oldOptions){
	// Create account page
	$options	= SIM\ADMIN\createDefaultPage($options, 'all-contacts-pages', 'All Users', '[all_contacts]', $oldOptions);

	return $options;
}

add_filter('display_post_states', __NAMESPACE__.'\postStates', 10, 2);
function postStates( $states, $post ) {

	if ( in_array($post->ID, SIM\getModuleOption(MODULE_SLUG, 'all-contacts-pages', false)) ) {
		$states[] = __('Page showing all users');
	}

	return $states;
}

add_action('sim_module_userpages_deactivated', __NAMESPACE__.'\moduleDeActivated');
function moduleDeActivated($options){
	foreach($options['all-contacts-pages'] as $page){
		// Remove the auto created page
		wp_delete_post($page, true);
	}
}
