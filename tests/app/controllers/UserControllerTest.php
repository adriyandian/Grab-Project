<?php

use \GP\Models\User;
use Slim\Environment;

class UserControllerTest extends PHPUnit_Framework_TestCase {

    protected $em;

    protected $app;

    public function setUp() {
        $this->em = getEntityManager(true);
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

        $mdFactory = $this->em->getMetadataFactory();
        $tool->dropSchema($mdFactory->getallMetadata());
        $tool->createSchema($mdFactory->getallMetadata());
        parent::setUp();

        $_SESSION = array();
        $this->app = new \Slim\Slim();
    }

    public function tearDown() {
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

        $mdFactory = $this->em->getMetadataFactory();
        $tool->dropSchema($mdFactory->getallMetadata());
        parent::tearDown();
    }

    public function testUserCreate() {
        Environment::mock(array(
           'slim.input' => 'login=world'
       ));

       $response = $this->app->request()->post();

       var_dump($response); exit;
    }
}
