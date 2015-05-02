<?php

namespace ImageUploader\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks
 */
class Image {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\ImageUploader\Models\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user_id;

    /**
     * @ORM\ManyToMany(targetEntity="\ImageUploader\Models\HashTag", inversedBy="images")
     * @ORM\JoinTable(name="images_hashtags")
     */
    protected $hashTags;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $location;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $imageSize;

    public function __construct() {
        $this->hashTags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of User Id
     *
     * @param mixed user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
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
     * Get the value of Location
     *
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of Location
     *
     * @param mixed location
     *
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of Image Size
     *
     * @return mixed
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set the value of Image Size
     *
     * @param mixed imageSize
     *
     * @return self
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtTimeStamp() {
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DatTime());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtTimeStamp() {
        if (is_null($this->getUpdatedAt())) {
            $this->setUpdatedAt(new \DatTime());
        }
    }

}
