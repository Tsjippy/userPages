<?php
namespace TSJIPPY\;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AdminMenu extends ADMIN\SubAdminMenu{

    public function __construct($settings, $name){
        parent::__construct($settings, $name);
    }

    public function settings($parent){
        return false;
    }

    public function emails($parent){
        return false;
    }

    public function data($parent=''){

        return false;
    }

    public function functions($parent){

        return false;
    }

    /**
     * Function to do extra actions from $_POST data. Overwrite if needed
     */
    public function postActions(){
        return '';
    }

    /**
     * Schedules the tasks for this plugin
     *
    */
    public function postSettingsSave(){
        scheduleTasks();
    }
}