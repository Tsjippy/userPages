<?php
namespace SIM\USERPAGES;
use SIM;

add_filter('sim_transform_formtable_data', function($string, $elementName){
    if($elementName == 'userid'){
			
        $output				= getUserPageLink($string);
        if(!$output){
            $output	= $string;
        }
    }

    return $output;
}, 10, 2);