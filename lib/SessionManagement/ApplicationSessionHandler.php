<?php

namespace SessionManagement;

class ApplicationSessionHandler {

    const SESSION_NAME = 'auth_token';

    protected $sessionName;

    protected $entityManager;

    protected $userEntityClass;

    public function __construct($entityManager, $userEntityClass) {
        if (!class_exists($userEntityClass)) {
            throw new \Exception('User Entity Class must be a class');
        }

        if (!is_callable($entityManager)) {
            throw new \Exception('Entitymanager must be callabale');
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->entityManager   = $entityManager;
        $this->userEntityClass = $userEntityClass;
    }

    public function createSession($userAuth) {
        $_SESSION[self::SESSION_NAME] = $userAuth;
    }

    public function getCurrentUser() {
        $entityManager = call_user_func($this->entityManager);
        $user = $entityManager->getRepository($this->userEntityClass)
                              ->findBy(array(
                                  'auth_token' => $_SESSION[self::SESSION_NAME]
                                ));

        if (!empty($user)) {
            return $user[0];
        }

        return null;
    }

    public function destroySession() {
        if (isset($_SESSION[self::SESSION_NAME])) {
            unset($_SESSION[self::SESSION_NAME]);
            return true;
        }

        return false;
    }
}
