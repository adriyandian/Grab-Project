<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;
use \Freya\Flash\Flash;
use \Lib\Session\Encrypt\EncryptHandler;
use \ImageUploader\Models\User;
use Symfony\Component\Validator\Validation as Validator;

class SessionController implements \Lib\Controller\BaseController  {

    const KEY = 'image_uploader_';

    public static function indexAction($params = null) {

    }


    public static function showAction($params){
    }


    public static function createAction($params){
      $postParams = $params->request()->post();
      $flash = new Flash();

      $user = getEntityManager()->getRepository('\ImageUploader\Models\User');

      $userObject = $user->findBy(array('user_name' => $postParams['username']));

      if (empty($userObject)) {
        $flash->createFlash('error', 'User does not exist.');
        $params->redirect('/signin');
      }

      if (!$userObject[0]->checkPassword($postParams['password'])) {
        $flash->createFlash('error', 'Invalid Password');
        $params->redirect('/signin');
      }

      $_SESSION[KEY . $userObject[0]->getId()] = serialize($userObject[0]->getUserName());
      $_SESSION[KEY . $userObject[0]->getId() . '_created'] = time();

      $flash->createFlash('success', 'Welcome back ' . $userObject[0]->getFirstName());
      $params->redirect('/dashboard');

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
