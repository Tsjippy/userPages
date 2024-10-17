<?php
namespace SIM\USERPAGES;
use SIM;

const MODULE_VERSION		= '8.05';
//module slug is the same as grandparent folder name
DEFINE(__NAMESPACE__.'\MODULE_SLUG', strtolower(basename(dirname(__DIR__))));

DEFINE(__NAMESPACE__.'\MODULE_PATH', str_replace('\\', '/', plugin_dir_path(__DIR__)));

add_filter('sim_submenu_description', function($description, $moduleSlug){
	//module slug should be the same as the constant
	if($moduleSlug != MODULE_SLUG)	{
		return $description;
	}

	ob_start();
	$url		= SIM\ADMIN\getDefaultPageLink($moduleSlug, 'allcontacts_pages');
	if(!empty($url)){
		?>
		<p>
			<strong>Auto created page:</strong><br>
			<a href='<?php echo $url;?>'>User overview page</a><br>
		</p>
		<?php
	}
	return $description.ob_get_clean();
}, 10, 2);

add_filter('sim_module_updated', function($options, $moduleSlug, $oldOptions){
	//module slug should be the same as grandparent folder name
	if($moduleSlug != MODULE_SLUG){
		return $options;
	}

	// Create account page
	$options	= SIM\ADMIN\createDefaultPage($options, 'allcontacts_pages', 'All Users', '[all_contacts]', $oldOptions);

	return $options;
}, 10, 3);

add_filter('display_post_states', function ( $states, $post ) {

	if ( in_array($post->ID, SIM\getModuleOption(MODULE_SLUG, 'allcontacts_pages', false)) ) {
		$states[] = __('Page showing all users');
	}

	return $states;
}, 10, 2);

add_action('sim_module_deactivated', function($moduleSlug, $options){
	//module slug should be the same as grandparent folder name
	if($moduleSlug != MODULE_SLUG)	{
		return;
	}

	foreach($options['allcontacts_pages'] as $page){
		// Remove the auto created page
		wp_delete_post($page, true);
	}
}, 10, 2);