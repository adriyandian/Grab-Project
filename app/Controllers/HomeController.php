<?php

namespace GP\Controllers;

use \Freya\Factory\Pattern;
use \ControllerManagement\BaseController;

class HomeController implements BaseController  {

    public static function indexAction($params = null) {

    }


    public static function showAction($params){
    }


    public static function createAction($params){

    }


    public static function updateAction($params){

    }


    public static function deleteAction($params){

    }

    public static function showHome() {
        Pattern::create('\Freya\Templates\Builder')->renderView('home/home',
            array(
                'flash' => new \Freya\Flash\Flash(),
                'template' => Pattern::create('\Freya\Templates\Builder')
            )
        );
    }

}
