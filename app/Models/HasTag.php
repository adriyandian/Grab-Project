<?php

namespace GP\Models;

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
    protected $hash_tag;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="\GP\Models\Image", mappedBy="hashTags")
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
        return $this->hash_tag;
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
            $this->hash_tag = $hashTag;
        } else {
            return false;
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
        return $this->create_at;
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
        $this->created_at = $createdAt;

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
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

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
