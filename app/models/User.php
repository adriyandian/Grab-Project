<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     */
    protected $userName;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     * @Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=500, nullable=false)
     */
    protected $password;


    /**
     * @ORM\Get the value of First Name
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of First Name
     *
     * @param mixed firstName
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of Last Name
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of Last Name
     *
     * @param mixed lastName
     *
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of User Name
     *
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set the value of User Name
     *
     * @param mixed userName
     *
     * @return self
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set ths password.
     *
     * @param string password
     *
     * @return self
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Check the users password against that which is enterd.
     *
     * @param string password
     *
     * @return bool
     */
    public function checkPassword($password) {
        if (password_hash($password, PASSWORD_DEFAULT) === $this->getPassword()) {
            return true;
        }

        return false;
    }

    /**
     * Return the password value.
     *
     * @return hash
     */
    private function getPassword(){
        return $this->password;
    }
}
