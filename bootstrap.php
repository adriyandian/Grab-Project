<?php
/** ---------------------------------------------------------------- **/
// We need some constants.
/** ---------------------------------------------------------------- **/
if (!defined('APP')) {
    define('APP', dirname(__FILE__) . '/app/');
}

if (!defined('APP_MODELS')) {
    define('APP_MODELS', dirname(__FILE__) . '/app/Models/');
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

$loader = require 'vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Set up Doctrine.
 */
class DoctrineSetup {

    /**
     * @var DoctrineSetup
     */
    protected static $classInstance;

    /**
     * @var array $paths - where the entities live.
     */
    protected $paths = array(APP_MODELS);

    /**
     * @var bool are we in development mode?
     */
    protected $isDevMode = true;

    /**
     * @var array database paramters
     */
    protected $dbParams;

    /**
     * Set up the database connection information.
     *
     * We will explode if we cannot find the db_config.ini
     */
    public function __construct() {
        if (!file_exists('db_config.ini')) {
            throw new \Exception(
                'Missing db_config.ini. You can create this from the db_config_sample.ini'
            );
        }

        // Database info.
        $this->dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => parse_ini_file('db_config.ini')['DB_USER'],
            'password' => parse_ini_file('db_config.ini')['DB_PASSWORD'],
            'dbname' => parse_ini_file('db_config.ini')['DB_NAME']
        );
    }

    /**
     * Return the entity manager for managing the database.
     *
     * @return Doctrine\ORM\EntityManager instance
     */
    public function getEntityManager() {
        // finally set up and connect.
        $config = Setup::createAnnotationMetadataConfiguration($this->paths, $this->isDevMode, null, null, false);
        $entityManager = EntityManager::create($this->dbParams, $config);

        return $entityManager;
    }
}

// Function to easily get the Entity manager
// when ever we need it.
function getEntityManager() {
    $ds = new DoctrineSetup();
    return $ds->getEntityManager();
     * @var bool $isDevMode - Are we considered "in development."
     */
    protected $isDevMode = false;

    /**
     * @var array $dbParams - The database paramters.
     */
    protected $dbParams = null;

    /**
     * Cannot instantate the class
     */
    private function __construct(){}

    /**
     *  Use me to create an instance of the class.
     *
     * @return DoctrineSetup
     */
    public static function getInstance() {
      if (self::$classInstance === null) {
          self::$classInstance = new self();
      }

      return self::$classInstance;
    }

    /**
     *  Call me to set up the required params.
     */
    public function setUp() {
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
 *  Basic Entity Manager Container.
 */
class EntityManagerContainer
{
    /**
     * @var EntityManagerContainer
     */
    private static $instance;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Basic constructor - This class cannot be instantiated
     */
    private function __construct()
    {
        $ds = DoctrineSetup::getInstance();
        $ds->setUp();
        $this->em = $ds->getEntityManager();
    }

    /**
     * Get an instance of this class.
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance= new self();
        }

        return self::$instance;
    }

    /**
     * Get the entityManager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}

/**
 * Function that can be called through out the app.
 *
 * @return EntityManager
 */
function getEntityManager() {
  return EntityManagerContainer::getInstance()->getEntityManager();
}

/**
 * Function that returns the conection to the database.
 */
function getConnection() {
    $ds = DoctrineSetup::getInstance();
    $ds->setUp();
    return $ds->getEntityManager()->getConnection();
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
    'ImageUploader' => APP,
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
