<?php
namespace TSJIPPY\USERPAGES;
use TSJIPPY;

add_filter('tsjippy_transform_formtable_data', __NAMESPACE__.'\formtableData', 10, 2);
function formtableData($string, $elementName){
    if($elementName == 'user-id'){
			
        $output				= getUserPageLink($string);
        if($output){
            $string	= $output;
        }
    }

    return $string;
}

add_filter('display_post_states', __NAMESPACE__.'\postStates', 10, 2);
function postStates( $states, $post ) {

	if ( $post->ID == SETTINGS['all-contacts-page'] ?? false ) {
		$states[] = __('Page showing all users');
	}

	return $states;
}

/**
 * Create a user page on user registration or approval
 */
add_action( 'tsjippy_approved_user', __NAMESPACE__.'\userApproved' );
function userApproved($userId){
    if(get_user_meta( $userId, 'disabled', true) == 'pending'){
        return;
    }

    createUserPage($userId);
}

add_action('delete_user', __NAMESPACE__.'\userDeleted');
function userDeleted($userId){
    $family     = new TSJIPPY\FAMILY\Family();
    $partner    = $family->getPartner($userId, true);

	//Only remove if there is no family
	if (!$partner){
        //Check if a page exists for this person
        $userPage    = getUserPageId($userId);
        if (is_numeric($userPage)){
            //page exists, delete it
            wp_delete_post($userPage);
            TSJIPPY\printArray("Deleted the user page $userPage");
        }
    }else{
        //Get the partners display name to use as the new title
        $title = $partner->display_name;

        //Update
        updateUserPageTitle($partner->ID, $title);
    }
}