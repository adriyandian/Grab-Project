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
    Controller\UserController::showSignupForm();
});

$app->get('/signin', function(){
    Controller\SessionController::showSignInForm();
});

$app->get('/dashboard', function(){
    Controller\DashboardController::indexAction();
});

$app->post('/session/create', function() use ($app){
    Controller\SessionController::createAction($app);
});

$app->post('/signup/new', function() use ($app){
  Controller\UserController::createAction($app);
});

// Don't touch.
$app->run();
