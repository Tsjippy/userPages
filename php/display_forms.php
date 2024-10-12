<?php
namespace SIM\USERPAGES;
use SIM;

add_filter('sim_transform_formtable_data', function($string, $elementName){
    if($elementName == 'userid'){
			
        $output				= getUserPageLink($string);
        if($output){
            $string	= $output;
        }
    }

    return $string;
}, 10, 2);
