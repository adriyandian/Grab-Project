<?php
/** ---------------------------------------------------------------- **/
// We need some constants.
/** ---------------------------------------------------------------- **/
if (!defined('DB_SCRIPTS')) {
    define('DB_SCRIPTS', 'app/db');
}

if (!defined('APP_CONTROLLERS')) {
    define('APP_CONTROLLERS', 'app/controllers/');
}

if (!defined('APP_MODELS')) {
    define('APP_MODELS', 'app/models/');
}

if (!defined('APP_VIEWS')) {
    define('APP_MODELS', 'app/views/');
}

if (!defined('APP_VIEWS_PARTIALS')) {
    define('APP_MODELS', 'app/views/partials/');
}

if (!defined('LIB')) {
    define('LIB', 'lib/');
}
/** ---------------------------------------------------------------- **/
// Lets Setup Doctrine.
/** ---------------------------------------------------------------- **/
require_once 'vendor/autoload.php';


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Where do the db scripts sit? And, are we in development mode?
$paths = array(DB_SCRIPTS);
$isDevMode = false;

//Now to set up connection.
if (!file_exists('db_config.ini')) {
    throw new \Exception(
        'Missing db_config.ini. You can create this from the db_config_sample.ini'
    );
}

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => parse_ini_file('db_config.ini')['DB_USER'],
    'password' => parse_ini_file('db_config.ini')['DB_PASSWORD'],
    'dbname' => parse_ini_file('db_config.ini')['DB_NAME']
);

// finally set up and connect.
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

/** ---------------------------------------------------------------- **/
// Now we need to set up the autoloader.
//
// This loader is used in a web framework I am developing for
// WordPress called Freya: https://github.com/AdamKyle/Freya
//
// While the framework is more designed for WordPress, it is a
// Modular system allowing me to bring in peices of it for this
// project.
/** ---------------------------------------------------------------- **/
use Freya\Loader\AutoLoader;

// Instantiation.
$autoLoader = new AutoLoader();

// Set up custom name spaces.
$autoLoader->registerNameSpaces(array(
    'AC' => APP_CONTROLLERS,
    'AM' => APP_MODELS,
    'SCC' => LIB . 'custom_slim_controller/'
));

// Now register the autoloader.
$autoLoader->register_auto_loader();

/** ---------------------------------------------------------------- **/
// Now we need to set up the template manager
//
// This loader is used in a web framework I am developing for
// WordPress called Freya: https://github.com/AdamKyle/Freya
//
// While the framework is more designed for WordPress, it is a
// Modular system allowing me to bring in peices of it for this
// project.
//
// This will allow us to just render templates as we see fit,
// by setting up the paths to these templates. To do this we need
// another package called Freya Factory. it allows us to create
// Instances of the template builder class on the fly.
/** ---------------------------------------------------------------- **/
use Freya\Factory\Pattern;

// Set up our dependency array.
$dependencies = array(
    '\Freya\Template\Builder' => array(
        'params' => array(
            'views' => array(
                'core_views' => APP_VIEWS
            ),
            'partials' => array(
                'core_partials' => APP_VIEWS_PARTIALS
            )
        )
    )
);

// Register the dependencies.
Parrent::registerDependencies($dependencies);

/** ---------------------------------------------------------------- **/
// Now we need to set up the custom exception handler.
//
// This loader is used in a web framework I am developing for
// WordPress called Freya: https://github.com/AdamKyle/Freya
//
// While the framework is more designed for WordPress, it is a
// Modular system allowing me to bring in peices of it for this
// project.
/** ---------------------------------------------------------------- **/
use Freya\Exceptions\ExceptionHandler;

// Simply Instantiate and off we go.
new ExceptionHandler();
