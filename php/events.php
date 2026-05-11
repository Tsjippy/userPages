<?php
namespace TSJIPPY\USERPAGES;

add_filter('tsjippy-events-event-url', __NAMESPACE__.'\eventUrl', 10, 3);
/**
 * Modify the URL for an event based on the user ID
 * @param string $url The original URL
 * @param int $userId The user ID
 * @param object $object The event object
 * @return string The modified URL
 */
function eventUrl($url, $userId, $object){

    if(is_numeric($userId)){
        //Get the user page of this user
        $link	= getUserPageLink($userId);

        if($link){
            $url    = $link;
        }
    }

    return $url;
}