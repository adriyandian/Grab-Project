<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;

class SignupController implements \Lib\Controller\BaseController  {

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

    public static function showSignupForm() {
        Pattern::create('\Freya\Templates\Builder')->renderView('signup\signup_form');
    }

}
