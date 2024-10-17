<?php
namespace SIM\USERPAGES;

add_filter('sim-events-event-url', function($url, $userId, $object){

    if(is_numeric($userId)){
        //Get the user page of this user
        $link	= getUserPageLink($userId);

        if($link){
            $url    = $link;
        }
    }

    return $url;
}, 10, 3);