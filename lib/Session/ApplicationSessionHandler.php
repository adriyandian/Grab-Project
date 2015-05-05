<?php

namespace Lib\Session;

class ApplicationSessionHandler {

    protected static $classInstance;

    protected static $authToken;

    private static $userEntityClass;

    private static $entityManager;

    private function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function getInstance($entityClass = null, $entityManager = null) {
        if (self::$classInstance === null) {
            if ($entityClass != null && !class_exists($entityClass)) {
                throw new \Exception('Entity class passed in does not exist.');
            }

            if ($entityManager != null && !is_callable($entityManager)) {
                throw new \Exception('Entity manager passed in is not callable.');
            }

            if (self::$userEntityClass === null) {
                self::$userEntityClass = $entityClass;
            }

            if (self::$entityManager === null) {
                self::$entityManager = $entityManager;
            }

            self::$classInstance = new self();
        }

        return self::$classInstance;
    }

    public function createSession($userAuth) {
        if (self::$authToken === null) {
            self::$authToken = $userAuth ;

            $_SESSION[$userAuth] = $userAuth;
        }
    }

    public function getCurrentUser() {
        if (self::$authToken === null) {
            return null;
        }

        $user = $entityManager->getRepository($userEntityClass);
        $userObject = $user->findBy(array('auth_toke' => self::$authToken));

        if (empty($userObject)) {
            return null;
        }

        return $userObject[0];
    }

    public function destroySession() {
        if (self::$authToken === null) {
            return false;
        }

        unset($_SESSION[self::$authToken]);
        self::$authToken = null;

        return true;
    }
}
