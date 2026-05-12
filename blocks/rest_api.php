<?php
namespace TSJIPPY\USERPAGES;
use TSJIPPY;

add_action( 'rest_api_init',  __NAMESPACE__.'\restApiInit');
function restApiInit() {
	// show schedules
	register_rest_route( 
		RESTAPIPREFIX.'/userpage', 
		'/linked_user_description', 
		array(
			'methods' 				=> 'GET',
			'callback' 				=> function(){
				return linkedUserDescription($_REQUEST);
			},
			'permission_callback' 	=> function(){
				return current_user_can('read');
			},
		)
	);
}