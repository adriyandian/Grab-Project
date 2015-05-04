<?php

namespace ImageUploader\Models;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \Lib\Validators\UniqueValidator\Constraints as CustomAssert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={
 *   @ORM\UniqueConstraint(name="user", columns={"user_name", "email"})}
 * )
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
     * @Assert\NotBlank()
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     * @Assert\NotBlank()
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     * @Assert\NotBlank(
     *    message = "Username cannot be blank"
     * )
     * @CustomAssert\UserName(
     *     entityManager = "getEntityManager",
     *     entityClass = "\ImageUploader\Models\User"
     * )
     */
    protected $user_name;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     * @Assert\NotBlank(
     *   message = "Email field cannot be blank."
     * )
     * @Assert\Email(
     *    message = "The email you entered is invalid.",
     *    checkMX = true
     * )
     * @CustomAssert\Email(
     *     entityManager = "getEntityManager",
     *     entityClass = "\ImageUploader\Models\User"
     * )
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=500, nullable=false)
     * @Assert\NotBlank(
     *  message = "The password field cannot be empty."
     * )
     */
    protected $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    public function getId() {
      return $this->$id;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed created_at
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $created_at = null)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updated_at
     *
     * @return self
     */
    public function setUpdatedAt(\DateTime $updated_at = null)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of First Name
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
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
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get the value of Last Name
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
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
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get the value of User Name
     *
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
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
        $this->user_name = $userName;

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
     * @return self or false
     */
    public function setPassword($password) {
        // We need 10 actual acharacters not 11, so we check for 10 indexes
        // 0 - 9 == 1-10 for strlen.
        if ($password !== null && strlen($password) > 9) {
          $this->password = password_hash($password, PASSWORD_DEFAULT);
          return $this;
        }

        return false;
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

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtTimeStamp() {
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtTimeStamp() {
        if (is_null($this->getUpdatedAt())) {
            $this->setUpdatedAt(new \DateTime());
        }
    }
}
