<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:21 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="venueimage")
 **/
class VenueImageEntity
{
    /**
     * @var $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id", unique=true)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false, name="venueId")
     */
    protected $venueId;

    /**
     * @ORM\Column(type="integer", nullable=false, name="userId")
     */
    protected $userId;

    /**
     * @ORM\Column(type="string", nullable=false, name="imageUrl")
     */
    protected $imageUrl;

    /**
     * @ORM\Column(type="integer", nullable=false, name="isApproved")
     */
    protected $isApproved;

    /**
     * @ORM\Column(type="integer", nullable=false, name="isAwaitingModeration")
     */
    protected $isAwaitingModeration;

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Oradea\HackTM\Entity\VenueEntity", inversedBy="venues")
     * @ORM\JoinColumn(name="venueId", referencedColumnName="id")
     */
    private $venues;

    /**
     * @return mixed
     */
    public function getVenues()
    {
        return $this->venues;
    }

    /**
     * @param mixed $venues
     */
    public function setVenues($venues): void
    {
        $this->venues = $venues;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }/**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }/**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }/**
     * @param mixed $venueId
     */
    public function setVenueId($venueId): void
    {
        $this->venueId = $venueId;
    }/**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }/**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }/**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }/**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }/**
     * @return mixed
     */
    public function getisApproved()
    {
        return $this->isApproved;
    }/**
     * @param mixed $isApproved
     */
    public function setIsApproved($isApproved): void
    {
        $this->isApproved = $isApproved;
    }/**
     * @return mixed
     */
    public function getisAwaitingModeration()
    {
        return $this->isAwaitingModeration;
    }/**
     * @param mixed $isAwaitingModeration
     */
    public function setIsAwaitingModeration($isAwaitingModeration): void
    {
        $this->isAwaitingModeration = $isAwaitingModeration;
    }

    public function toArray()
    {
        return [
            'id' => (int)$this->getId(),
            'userId' => (int)$this->getUserId(),
            'venueId' => (int)$this->getVenueId(),
            'imageUrl' => $this->getImageUrl(),
            'isApproved' => (int)$this->getisApproved(),
            'isAwaitingModeration' => (int)$this->getisAwaitingModeration(),
        ];
    }
}