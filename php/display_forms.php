<?php
namespace SIM\USERPAGES;

add_filter('sim_transform_formtable_data', __NAMESPACE__.'\formtableData', 10, 2);
function formtableData($string, $elementName){
    if($elementName == 'user-id'){
			
        $output				= getUserPageLink($string);
        if($output){
            $string	= $output;
        }
    }

    return $string;
}
