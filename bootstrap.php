<?php
/** ---------------------------------------------------------------- **/
// We need some constants.
/** ---------------------------------------------------------------- **/
if (!defined('APP')) {
    define('APP', dirname(__FILE__) . '/app/');
}

if (!defined('APP_VIEWS')) {
    define('APP_VIEWS', 'app/views/');
}

if (!defined('APP_VIEWS_PARTIALS')) {
    define('APP_VIEWS_PARTIALS', 'app/views/partials/');
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

/**
 * Set up Doctrine.
 */
class DoctrineSetup {

    /**
     * @var array $paths - where the entities live.
     */
    protected $paths = array(APP . 'models/');

    /**
     * @var bool $isDevMode - Are we considered "in development."
     */
    protected $isDevMode = false;

    /**
     * @var array $dbParams - The database paramters.
     */
    protected $dbParams = null;

    /**
     * Constructor to set some core values.
     */
    public function __construct(){
        if (!file_exists('db_config.ini')) {
            throw new \Exception(
                'Missing db_config.ini. You can create this from the db_config_sample.ini'
            );
        }

        $this->dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => parse_ini_file('db_config.ini')['DB_USER'],
            'password' => parse_ini_file('db_config.ini')['DB_PASSWORD'],
            'dbname' => parse_ini_file('db_config.ini')['DB_NAME']
        );
    }

    /**
     * Get the entity manager for use through out the app.
     *
     * @return EntityManager
     */
    public function getEntityManager() {
        $config = Setup::createAnnotationMetadataConfiguration($this->paths, $this->isDevMode, null, null, false);
        return EntityManager::create($this->dbParams, $config);
    }
}

/**
 * Function that can be called through out the app.
 *
 * @return EntityManager
 */
public function getEnetityManager() {
    $ds = new DoctrineSetup();
    return $ds->getEntityManager();
}

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
    'ImageUploader' => dirname(__FILE__) . '/' . APP,
    'Lib'=> dirname(__FILE__) . '/' . LIB
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
    '\Freya\Templates\Builder' => array(
        'params' => array(
            array(
                'views' => array(
                    'core_views' => APP_VIEWS
                ),
                'partials' => array(
                    'core_partials' => APP_VIEWS_PARTIALS
                )
            )
        )
    )
);

// Register the dependencies.
Pattern::registerDependencies($dependencies);

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
