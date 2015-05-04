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

$app->get('/signin', function() use ($app){
    Controller\SessionController::showSignInForm($app);
});

$app->get('/signup/error', function(){
    Controller\SignupController::showSignupForm();
});

$app->post('/signup/new', function() use ($app){
  Controller\SignupController::createAction($app);
});

// Don't touch.
$app->run();
