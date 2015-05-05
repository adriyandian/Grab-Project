<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;
use \Lib\Session\ApplicationSessionHandler;
use \Freya\Flash\Flash;

class DashboardController implements \Lib\Controller\BaseController   {

    public function beforeAction($actionName, $actionArgs) {
        $session = ApplicationSessionHandler::getInstance();

        if ($session->getCurrentUser() === null) {
            $flash = new Flash();
            $flash->createFlash('error', 'You have to sign in to access that.');
            $actionArgs[0]->redirect('/signin');
        }
    }

    public static function indexAction($params = null) {
      Pattern::create('\Freya\Templates\Builder')->renderView(
          'dash/home',
          array(
              'flash' => new Flash(),
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
