<?php
/** ---------------------------------------------------------------- **/
// We want to use the console tool so we need to register the
// applications EntityManger to the console.
//
// command line: php vendor/bin/doctrine
/** ---------------------------------------------------------------- **/
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Use  our bootstrap file.
require_once 'bootstrap.php';

// Use our entity manager.
$entityManager = GetEntitiyManager();

return ConsoleRunner::createHelpersSet($entityManbaer);
