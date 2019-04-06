<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:13 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="sport")
 **/
class SportEntity
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
     * @ORM\Column(type="string", nullable=false, name="name")
     */
    protected $name;


    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Oradea\HackTM\Entity\VenueEntity", mappedBy="sports")
     */
    private $venues;

    public function __construct() {
        $this->venues = new ArrayCollection();
    }

    public function getVenues()
    {
        return $this->venues;
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

    public function toArray()
    {
        return [
            'id' => (int)$this->getId(),
            'name' => $this->getName(),
            'venues' => $this->getVenues()->map(function($entity) {return $entity->toArray();})->toArray(),
        ];
    }
}