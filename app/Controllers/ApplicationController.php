<?php

namespace ImageUploader\Controllers;

/**
 *  The core Application controller.
 */
class ApplicationController {

    protected static $controllerClass;

    public function __construct(\Lib\Controller\BaseController $controller) {
        self::$controllerClass = $controller;
    }

    public static function __callStatic($name, $args) {
        $object = self::$controllerClass;
        if (is_callable(array($object, $name))) {
            if (method_exists($object, 'beforeAction')) {
                call_user_func_array(array($object, 'beforeAction'), array($name, $args));
            }

            // Call the action.
            $action = call_user_func_array(array($object, $name), $args);

            if (method_exists($object, 'afterAction')) {
                call_user_func_array(array($object, 'afterAction'), array($name, $args));
            }

            return $action;
        } else {
            throw new \Exception('Method does not exist.');
        }
    }


}
