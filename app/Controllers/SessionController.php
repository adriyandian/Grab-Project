<?php

namespace GP\Controllers;

use \Freya\Factory\Pattern;
use \Freya\Flash\Flash;
use \SessionManagement\Encrypt\EncryptHandler;
use \ControllerManagement\BaseController;
use \GP\Models\User;

class SessionController implements BaseController   {

    const KEY = 'image_uploader_';

    public static function indexAction($params = null) {

    }


    public static function showAction($params){
    }


    public static function createAction($params){
        $postParams = $params->request()->post();
        $flash = new Flash();

        $user = getEntityManager()->getRepository('\GP\Models\User');

        $userObject = $user->findBy(array('user_name' => $postParams['username']));

        if (empty($userObject)) {
            $flash->createFlash('error', 'User does not exist.');
            $params->redirect('/signin');
        }

        if (!$userObject[0]->checkPassword($postParams['password'])) {
            $flash->createFlash('error', 'Invalid Password');
            $params->redirect('/signin');
        }

        Pattern::create('\\SessionManagement\ApplicationSessionHandler')->createSession($userObject[0]->getAuthToken());
        $flash->createFlash('success', 'Welcome back ' . $userObject[0]->getFirstName());
        $params->redirect('/dashboard');
    }


    public static function updateAction($params){
    }


    public static function deleteAction($params){
        $flash = new Flash();
        Pattern::create('\\SessionManagement\ApplicationSessionHandler')->destroySession();
        $flash->createFlash('success', 'See you next time!');
        $params->redirect('/');
    }

    public static function showSignInForm($params) {
        $flash = new Flash();

        if (Pattern::create('\SessionManagement\ApplicationSessionHandler')->getCurrentUser() != null) {
            $flash->createFlash('notice', 'You already are signed in.');
            $params->redirect('/dashboard');
        }

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
