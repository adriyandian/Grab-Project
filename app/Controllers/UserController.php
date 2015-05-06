<?php

namespace ImageUploader\Controllers;

use \Freya\Factory\Pattern;
use \Freya\Flash\Flash;
use \Lib\Session\Encrypt\EncryptHandler;
use \ImageUploader\Models\User;
use Symfony\Component\Validator\Validation as Validator;

class UserController implements \Lib\Controller\BaseController  {

  public static function indexAction($params = null) {
  }


  public static function showAction($params){
  }

  public static function createAction($params) {
    $postParams = $params->request()->post();
    $flash = new Flash();

    if ($postParams['password'] !== $postParams['repassword']) {
      $flash->createFlash('error', 'Your passwords do not match.');
      self::createEncryptedPostParams($postParams);
      $params->redirect('/signup');
    }

    $user = new User();

    if (!$user->setPassword($postParams['password'])) {
      var_dump('here');
      $flash->createFlash('error', 'Password length myst be 10 characters');
      self::createEncryptedPostParams($postParams);
      $params->redirect('/signup');
    }

    $user->setFirstName($postParams['firstname'])
         ->setLastName($postParams['lastname'])
         ->setUserName($postParams['username'])
         ->setEmail($postParams['email']);

    $validator = Validator::createValidatorBuilder();
    $validator->enableAnnotationMapping();

    $errors = $validator->getValidator()->validate($user);

    if (count($errors) > 0) {
        foreach($errors as $error) {
          $flash->createFlash(
              $error->getPropertyPath() . 'error',
              $error->getMessage()
          );
      }

      self::createEncryptedPostParams($postParams);
      $params->redirect('/signup');
    }

    self::destroyEncryptedPostParams();

    try {
      getEntityManager()->persist($user);
      getEntityManager()->flush();
    } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
      if ($e->getSqlState() == "2300") {
        var_dump($e);
      }
    }

    $flash->createFlash('success', ' You have signed up successfully! Please sign in!');
    $params->redirect('/signin');
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
  }

  protected static function getEncryptedPostParams() {
    $encrypt = new EncryptHandler();
    $encryptedPostParamsData = $encrypt->read('error');

    if ($encryptedPostParamsData != null) {
      return $encryptedPostParamsData;
    }

    return null;
  }

  protected static function destroyEncryptedPostParams() {
    $encrypt = new EncryptHandler();
    $encryptedPostParamsData = $encrypt->read('error');
    if ($encryptedPostParamsData !== null) {
      $encrypt->destroy('error');
    }
  }
}
