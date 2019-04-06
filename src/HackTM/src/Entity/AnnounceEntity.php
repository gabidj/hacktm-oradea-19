<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:06 AM
 */

namespace Oradea\HackTM\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
 *
 * @ORM\Entity
 * @ORM\Table(name="announce")
 **/
class AnnounceEntity
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
     * @ORM\Column(type="integer", nullable=false, name="appointmentId")
     */
    protected $appointmentId;

    /**
     * @ORM\Column(type="integer", nullable=false, name="userId")
     */
    protected $userId;

    /**
     * @ORM\Column(type="integer", nullable=false, name="playersWanted")
     */
    protected $playersWanted;

    /**
     * @ORM\Column(type="float", nullable=false, name="price")
     */
    protected $price;

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
    public function getAppointmentId()
    {
        return $this->appointmentId;
    }

    /**
     * @param mixed $appointmentId
     */
    public function setAppointmentId($appointmentId): void
    {
        $this->appointmentId = $appointmentId;
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
    public function getPlayersWanted()
    {
        return $this->playersWanted;
    }

    /**
     * @param mixed $playersWanted
     */
    public function setPlayersWanted($playersWanted): void
    {
        $this->playersWanted = $playersWanted;
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

    public function toArray()
    {
        return [
            'id' => (int)$this->getId(),
            'appointmentId' => (int)$this->getAppointmentId(),
            'userId' => (int)$this->getAppointmentId(),
            'playersWanted' => (int)$this->getPlayersWanted(),
            'price' => $this->getPrice(),
        ];
    }
}