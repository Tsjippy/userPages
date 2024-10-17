<?php
namespace SIM\USERPAGES;

add_filter('sim_transform_formtable_data', function($string, $elementName){
    if($elementName == 'userid'){
			
        $output				= getUserPageLink($string);
        if($output){
            $string	= $output;
        }
    }

    return $string;
}, 10, 2);
