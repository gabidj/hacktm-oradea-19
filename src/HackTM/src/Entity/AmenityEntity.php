<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:11 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="amenity")
 **/
class AmenityEntity
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
     * @ORM\Column(type="string", nullable=false, name="description")
     */
    protected $description;

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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function toArray()
    {
        return [
            'id' => (int)$this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }
}
