<?php
namespace SIM\USERPAGES;

add_filter('sim-events-event-url', __NAMESPACE__.'\eventUrl', 10, 3);
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