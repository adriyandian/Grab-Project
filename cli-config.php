<?php
// Use  our bootstrap file.
require_once 'bootstrap.php';

/** ---------------------------------------------------------------- **/
// We want to use the console tool so we need to register the
// applications EntityManger to the console.
//
// command line: php vendor/bin/doctrine
/** ---------------------------------------------------------------- **/
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Application;

// Use our entity manager.
$entityManager = getEntityManager();

$connection = getConnection();

ConsoleRunner::createHelperSet($entityManager);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($connection),
    'dialog' => new \Symfony\Component\Console\Helper\DialogHelper(),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));

$cli = new Application('Doctrine Command Line Interface', \Doctrine\ORM\Version::VERSION);
$cli->setHelperSet($helperSet);

ConsoleRunner::addCommands($cli);

/** ---------------------------------------------------------------- **/
// Add all your commands bellow this block.
/** ---------------------------------------------------------------- **/
$cli->addCommands(array(
    // Migrations Commands
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand()
));

// Don't touch.
$cli->run();
