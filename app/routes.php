<?php
use \ImageUploader\Controllers as Controller;
/** ---------------------------------------------------------------- **/
// Routes.
//
// Routes are defined here. Nothing should happen in a route other then
// Calling  acontroller based action, such as: indexAction.
/** ---------------------------------------------------------------- **/
$app = new \Slim\Slim();

$app->get('/', function(){
    Controller\HomeController::showHome();
});

$app->get('/signup', function(){
    Controller\SignupController::showSignupForm();
});

$app->post('/signup/new', function() use ($app){
   var_dump($app->request()->post('username'));
   var_dump($app->request()->post('password'));
});

// Don't touch.
$app->run();
