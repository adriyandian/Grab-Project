<?php

namespace ControllerManagement;

/**
 * Used to set up the core actions of a controller.
 *
 * base Controller should be implemented by all controllers,
 * this allows them to implement and fill in the core action methods.
 *
 * While you are free to create your own actions for your own needs,
 * these ones give your app structure and help you organize your code better.
 */
interface BaseController {

    /**
     * Index Action.
     *
     * The index action can take in a set of params to help you
     * return a list of items related to that set of params.
     *
     * @param mixed $params
     */
    public static function indexAction($params = null);

    /**
     * Show Action
     *
     * The show action is used to show a single object.
     *
     * @param mixed params
     */
    public static function showAction($params);

    /**
     * Create Action
     *
     * Create action is designed to create on object based off the params passed in.
     *
     * @param mixed params
     */
    public static function createAction($params);

    /**
     * Update Action
     *
     * Update action is used to update a single object in the database.
     *
     * @param mixed params
     */
    public static function updateAction($params);

    /**
     * Update Action
     *
     * Delete action is used to delete a single object in the database.
     *
     * @param mixed params
     */
    public static function deleteAction($params);
}
