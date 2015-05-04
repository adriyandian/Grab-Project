<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;
use \Freya\Flash\Flash;
use \Lib\Session\Encrypt\EncryptHandler;
use \ImageUploader\Models\User;
use Symfony\Component\Validator\Validation as Validator;

class SessionController implements \Lib\Controller\BaseController  {

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

    public static function showSignInForm() {
        $data = self::getEncryptedPostParams();
        Pattern::create('\Freya\Templates\Builder')->renderView(
            'session/signin_form',
            array(
                'formData' => $data,
                'flash' => new Flash(),
                'template' => Pattern::create('\Freya\Templates\Builder')
            )
        );
    }

    protected static function createEncryptedPostParams($postParams) {
      $encrypt = new EncryptHandler();
      $encrypt->write('error', $postParams);
      $encrypt->gc(15);
    }

    protected static function getEncryptedPostParams() {
      $encrypt = new EncryptHandler();
      $encryptedPostParamsData = $encrypt->read('error');

      if ($encryptedPostParamsData != null) {
        return $encryptedPostParamsData;
      }

      return null;
    }

}
