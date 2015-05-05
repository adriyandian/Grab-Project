<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;

class DashboardController implements \Lib\Controller\BaseController  {

    public static function indexAction($params = null) {
      Pattern::create('\Freya\Templates\Builder')->renderView(
          'dash/home',
          array(
              'flash' => new \Freya\Flash\Flash(),
              'template' => Pattern::create('\Freya\Templates\Builder')
          )
      );
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
        Pattern::create('\Freya\Templates\Builder')->renderView('home/home');
    }

}
