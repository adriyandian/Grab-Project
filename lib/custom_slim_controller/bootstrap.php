<?php
/** ---------------------------------------------------------------- **/
// Setup the core components to allow phpunit to know
// where everything is.
/** ---------------------------------------------------------------- **/
use Freya\Loader\AutoLoader;

// Setup the vendor autoloader.
require_once '/vendor/autoload.php';

// Instantiate the autoloader.
$autoLoader = new AutoLoader();

// Set up the Slim Custom Controller name space.
$autoLoader->registerNameSpace('SCC', dirname(__DIR__) . "/");

// create the autoloader.
$autoLoader->register_auto_loader();
