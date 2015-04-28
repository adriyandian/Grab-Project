<?php

namesapce SCC;

class Slim extends \Slim\Slim {

    /**
     * @var array of most common used HTTP Methods.
     */
    protected $supportedHttpMethods = array(
        'GET', 'POST', 'PUT', 'DELETE'
    );

    public function addRoutes(array $routes) {
        foreach ($routes as $routeName => $action) {
            if (is_array($action)) {
                foreach ($action as $act) {
                    if (!isset($act['controller'])) {
                        require_once dirname(__DIR__) . '/excpetion/SlimError.php';
                        throw new \Exception\SlimError(
                            'controller:action must be set.'
                        );
                    }

                    if (!$this->determinHowToHandleAction($act)) {
                        require_once dirname(__DIR__) . '/excpetion/SlimError.php';
                        throw new \Exception\SlimError(
                            'We could not execute the route with the specified http method and params.'
                        );
                    }
                }
            } else {
                $controllerAction = explode(':' , $controller);
                call_user_func($controllerAction);
            }
        }
    }

    protected function determinHowToHandleAction($routeAction) {
        if (isset($routeAction['method']) && isset($routeAction['action_params'])) {
            return $this->handleAction(
                strtoupper($routeAction['method']),
                $routeAction['controller'],
                $routeAction['action_params']
            );
        } else if (isset($routeAction['method'])) {
            return $this->handleAction(
                strtoupper($routeAction['method']),
                $routeAction['controller']
            );
        } else if (isset($routeAction['action_params'])) {
            return $this->handleAction(
                null,
                $routeAction['controller'],
                $routeAction['action_params']
            );
        }  else {
            return $this->handleAction(
                null,
                $routeAction['controller']
            );
        }
    }

    protected function handleAction($method = null, $controller, $controllerParams = null) {
        if ($method != null) {
            if (!in_array($method, $this->supportedHttpMethods)) {
                require_once dirname(__DIR__) . '/excpetion/SlimError.php';
                throw new \Exception\SlimError(
                    'Current method does not exist in supported methods. Please use GET, POST, PUT, DELETE'
                );
            }
        }

        $controllerAction = explode(':' , $controller);

        if ($method != null && $controllerParams != null) {
            return $this->handleMethodAndParams($method, $controllerAction, $controllerParams);
        }


        if ($method != null) {
            if ($method == 'GET' && $controllerAction[1] == 'indexAction') {
                return call_user_func($controllerAction)
            }
        }

        if ($controllerParams != null) {
            return $this->handleParams(array $controllerAction, $controllerParams);
        }

        return call_user_func($controllerAction);
    }

    protected function handleMethodAndParams($method, array $controllerAction, $controllerParams) {

        if ($method == 'GET' && $controllerAction[1] == 'showAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($method == 'POST' && $controllerAction[1] == 'createAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($method == 'PUT' && $controllerAction[1] == 'updateAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($method == 'DELETE' && $controllerAction[1] == 'destroyAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        return false;
    }

    protected function handleParams(array $controllerAction, $controllerParams) {
        if ($controllerAction[1] == 'showAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($controllerAction[1] == 'createAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($controllerAction[1] == 'updateAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        if ($controllerAction[1] == 'destroyAction') {
            return call_user_func($controllerAction, array($controllerParams));
        }

        return false;
    }

}
