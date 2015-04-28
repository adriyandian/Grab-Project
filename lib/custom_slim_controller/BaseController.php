<?php

namespace SCC;

/**
 *
 */
class BaseController {

    /**
     *
     */
    public abstract indexAction(){}

    /**
     *
     */
    public abstract createAction($params){}

    /**
     *
     */
    public abstract updateAction($params){}

    /**
     *
     */
    public abstract showAction($params){}

    /**
     *
     */
    public abstract destroyAction($params){}
}
