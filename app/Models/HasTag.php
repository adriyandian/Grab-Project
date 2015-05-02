<?php

namespace ImageUploader\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hashtags")
 * @ORM\HasLifecycleCallbacks
 */
class HashTag {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $hashTag;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity="\ImageUploader\Models\Image", mappedBy="hashTags")
     */
    protected $images;

    public function __contsruct() {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get the value of Hash Tag
     *
     * @return mixed
     */
    public function getHashTag()
    {
        return $this->hashTag;
    }

    /**
     * Set the value of Hash Tag
     *
     * @param mixed hashTag
     *
     * @return self
     */
    public function setHashTag($hashTag)
    {
        if (strpos($hasTag, '#') != false && strpos($hasTag, '#') == 0) {
            $this->hashTag = $hashTag;
        } else {
            throw new \Exception('Missing # at the beginning. Tag is not valid.');
        }

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
