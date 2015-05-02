<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;
use \Freya\Flash\Flash;
use \Lib\Session\Encrypt\EncryptHandler;

class SignupController implements \Lib\Controller\BaseController  {

    public static function indexAction($params = null) {

    }


    public static function showAction($params){
    }


    public static function createAction($params){
      $postParams = $params->request()->post();

      if ($postParams['password'] !== $postParams['repassword']) {
        $flash = new Flash();
        $flash->createFlash('error', 'Your passwords do not match.');
        $params->redirect('/signup/error');
      }
    }


    public static function updateAction($params){

    }


    public static function deleteAction($params){

    }

    public static function showSignupForm() {
        $data = self::getEncryptedPostParams();
        Pattern::create('\Freya\Templates\Builder')->renderView(
            'signup/signup_form',
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
        $encrypt->destroy('error');
        return $encryptedPostParamsData;
      }

      return null;
    }

}
