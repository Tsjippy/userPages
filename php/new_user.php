<?php
namespace SIM\USERPAGES;
use SIM;

/**
 * Create a user page on user registration or approval
 */
add_action( 'sim_approved_user', __NAMESPACE__.'\userApproved' );
function userApproved($userId){
    if(get_user_meta( $userId, 'disabled', true) == 'pending'){
        return;
    }

    createUserPage($userId);
}