<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:00 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="review")
 **/
class ReviewEntity
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
     * @ORM\Column(type="integer", nullable=false, name="rating")
     */
    protected $rating;

    /**
     * @ORM\Column(type="string", nullable=false, name="reviewText")
     */
    protected $reviewText;

    /**
     * @ORM\Column(type="integer", nullable=false, name="userId")
     */
    protected $userId;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="reviewDate")
     */
    protected $reviewDate;

    /**
     * @ORM\Column(type="integer", nullable=false, name="venueId")
     */
    protected $venueId;

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Oradea\HackTM\Entity\VenueEntity", inversedBy="venues")
     * @ORM\JoinColumn(name="venueId", referencedColumnName="id")
     */
    private $venues;


    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Oradea\HackTM\Entity\UserEntity", inversedBy="review")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getReviewText()
    {
        return $this->reviewText;
    }

    /**
     * @param mixed $reviewText
     */
    public function setReviewText($reviewText): void
    {
        $this->reviewText = $reviewText;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }


    /**
     * @return mixed
     */
    public function getVenueId()
    {
        return $this->venueId;
    }

    /**
     * @param mixed $venueId
     */
    public function setVenueId($venueId): void
    {
        $this->venueId = $venueId;
    }

    /**
     * @return mixed
     */
    public function getReviewDate()
    {
        return $this->reviewDate;
    }

    /**
     * @param mixed $reviewDate
     */
    public function setReviewDate($reviewDate): void
    {
        $this->reviewDate = $reviewDate;
    }

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

    public function toArray()
    {
        return [
            'id' => (int)$this->getId(),
            'userId' => (int)$this->getUserId(),
            'rating' => (int)$this->getRating(),
            'review' => $this->getReviewText(),
            'venueId' => $this->getVenueId(),
            'reviewDate' => $this->getReviewDate(),
            'username' => ucfirst($this->getUser()->getUsername()),
        ];
    }
}