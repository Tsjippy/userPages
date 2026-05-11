<?php
namespace TSJIPPY\USERPAGES;
use TSJIPPY;

add_filter('tsjippy_transform_formtable_data', __NAMESPACE__.'\formtableData', 10, 2);
/**
 * Transform the data for a form table element
 * @param string $string The original string
 * @param string $elementSlug The slug of the element
 * @return string The transformed string
 */
function formtableData($string, $elementSlug){
    if($elementSlug == 'user-id'){
        $output		= getUserPageLink($string);
        if($output){
            $string	= $output;
        }
    }

    return $string;
}

add_filter('display_post_states', __NAMESPACE__.'\postStates', 10, 2);
/**
 * Display post states for the user page
 * @param array $states The array of post states
 * @param \WP_Post $post The post object
 * @return array The modified array of post states
 */
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
/**
 * Handle the approval of a user
 * @param int $userId The ID of the approved user
 */
function userApproved($userId){
    if(get_user_meta( $userId, 'disabled', true) == 'pending'){
        return;
    }

    createUserPage($userId);
}

add_action('delete_user', __NAMESPACE__.'\userDeleted');
/**
 * Handle the deletion of a user
 * @param int $userId The ID of the deleted user
 */
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

add_filter('signal-admin-display-name', __NAMESPACE__.'\getSenderDisplayName', 10, 2);
/**
 * Get the display name of the sender of a message. This is used in the admin menu of the signal plugin to show the name of the sender instead of the phone number
 * @param string $displayName The display name of the sender
 * @param \WP_User $user The user object of the sender
 * 
 * @return string The display name of the sender
 */
function getSenderDisplayName($displayName, $user){
    $sender	= getUserPageLink($user->ID);

    if(!$sender){
        return $displayName;
    }

    return $sender;
}