<?php

use \GP\Models\User;
use Symfony\Component\Validator\Validation as Validator;

class UserTest extends PHPUnit_Framework_TestCase {

    protected $em;

    public function setUp() {
        $this->em = getEntityManager(true);
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

        $mdFactory = $this->em->getMetadataFactory();
        $tool->dropSchema($mdFactory->getallMetadata());
        $tool->createSchema($mdFactory->getallMetadata());
        parent::setUp();
    }

    public function tearDown() {
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);

        $mdFactory = $this->em->getMetadataFactory();
        $tool->dropSchema($mdFactory->getallMetadata());
        parent::tearDown();
    }

    public function testValidUser() {
        $user = new User();

        $user->setFirstName('Adam')
             ->setLastName('Balan')
             ->setUserName('Adam_Balan')
             ->setEmail('Adam@gmail.com')
             ->setPassword('1234567890');

        $validator = Validator::createValidatorBuilder();
        $validator->enableAnnotationMapping();

        $this->assertEquals(0, count($validator->getValidator()->validate($user)));
    }

    public function testValidUserData() {
        $user = new User();

        $user->setFirstName('Adam')
             ->setLastName('Balan')
             ->setUserName('Adam_Balan')
             ->setEmail('Adam@gmail.com')
             ->setPassword('1234567890');

        $validator = Validator::createValidatorBuilder();
        $validator->enableAnnotationMapping();

        $this->em->persist($user);
        $this->em->flush();

        $userObject = $this->em->getRepository('\GP\Models\User')->findBy(array("first_name" => 'Adam'))[0];

        $this->assertEquals('Adam', $user->getFirstName());
        $this->assertEquals('Balan', $user->getLastName());
        $this->assertEquals('Adam_Balan', $user->getUserName());
        $this->assertEquals('Adam@gmail.com', $user->getEmail());
        $this->assertTrue($user->checkPassword('1234567890'));
    }

    public function testInValidUser() {
        $user = new User();

        $user->setFirstName('Adam')
             ->setLastName('Balan')
             ->setUserName('')
             ->setEmail('Adam@gmail.com')
             ->setPassword('1234567890');

        $validator = Validator::createValidatorBuilder();
        $validator->enableAnnotationMapping();

        $this->assertEquals(1, count($validator->getValidator()->validate($user)));
    }

    public function testDuplicateUserError() {
        $user = new User();
        $secondUser = new User();

        $user->setFirstName('Adam')
             ->setLastName('Balan')
             ->setUserName('Asam')
             ->setEmail('Adam@gmail.com')
             ->setPassword('1234567890');

        $this->em->persist($user);
        $this->em->flush();

        $secondUser->setFirstName('Sample')
                   ->setLastName('Balan')
                   ->setUserName('Asam')
                   ->setEmail('Adam@gmail.com')
                   ->setPassword('1234567890');

        $validator = Validator::createValidatorBuilder();
        $validator->enableAnnotationMapping();



        $this->assertEquals(2, count($validator->getValidator()->validate($secondUser)));
    }
}
