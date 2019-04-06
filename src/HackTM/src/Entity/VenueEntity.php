<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 1:09 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="venue")
 **/
class VenueEntity
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
     * @ORM\Column(type="float", nullable=false, name="latitude")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float", nullable=false, name="longitude")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", nullable=false, name="name")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer", nullable=false, name="surface")
     */
    protected $surface;

    /**
     * @ORM\Column(type="integer", nullable=false, name="mainSportId")
     */
    protected $mainSportId;

    /**
     * @ORM\Column(type="integer", nullable=false, name="startHour")
     */
    protected $startHour;

    /**
     * @ORM\Column(type="integer", nullable=false, name="endHour")
     */
    protected $endHour;

    /**
     * @ORM\Column(type="integer", nullable=false, name="price")
     */
    protected $price;

    /**
     * @ORM\Column(type="string", nullable=false, name="defaultImage")
     */
    protected $defaultImage;

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Oradea\HackTM\Entity\SportEntity", inversedBy="venues")
     * @ORM\JoinColumn(name="mainSportId", referencedColumnName="id")
     */
    private $sports;

    public function __construct() {
        $this->sports = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * @param mixed $defaultImage
     */
    public function setDefaultImage($defaultImage): void
    {
        $this->defaultImage = $defaultImage;
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * @param mixed $surface
     */
    public function setSurface($surface): void
    {
        $this->surface = $surface;
    }

    /**
     * @return mixed
     */
    public function getMainSportId()
    {
        return $this->mainSportId;
    }

    /**
     * @param mixed $mainSportId
     */
    public function setMainSportId($mainSportId): void
    {
        $this->mainSportId = $mainSportId;
    }

    /**
     * @return mixed
     */
    public function getStartHour()
    {
        return $this->startHour;
    }

    /**
     * @param mixed $startHour
     */
    public function setStartHour($startHour): void
    {
        $this->startHour = $startHour;
    }

    /**
     * @return mixed
     */
    public function getEndHour()
    {
        return $this->endHour;
    }

    /**
     * @param mixed $endHour
     */
    public function setEndHour($endHour): void
    {
        $this->endHour = $endHour;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getSports()
    {
        return $this->sports;
    }

    /**
     * @param mixed $sports
     */
    public function setSports($sports): void
    {
        $this->sports = $sports;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'name' => $this->getName(),
            'surface' => $this->getSurface(),
            'mainSportId' => $this->getMainSportId(),
            'price' => $this->getPrice(),
            'startHour' => $this->getStartHour(),
            'endHour' => $this->getEndHour(),
            'defaultImage' => $this->getDefaultImage(),
        ];
    }
}