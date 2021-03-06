<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:28 AM
 */

namespace Oradea\HackTM\Service;

use Doctrine\ORM\EntityManager;
use Oradea\HackTM\Entity\ReviewEntity;
use Oradea\HackTM\Entity\SportEntity;
use Oradea\HackTM\Entity\VenueEntity;
use Oradea\HackTM\Entity\VenueImageEntity;

use Zend\Expressive\Helper\ServerUrlHelper;

class HackTmService
{
    use AppointmentsTrait;
    protected $entityManager;
    protected $urlHelper;
    protected $entityRepository;

    public function __construct(EntityManager $entityManager, ServerUrlHelper $urlHelper)
    {
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
    }

    public function test()
    {
       return $this->entityManager->getRepository(SportEntity::class)->findOneBy(['id'=>1]);
    }

    public function getSport($sportName)
    {
        $data = $this->entityManager->getRepository(SportEntity::class)->findOneBy(['name'=>$sportName]);
        if ($data === null) {
            return;
        }
        return $data->toArray();
    }

    public function getVenueById($id)
    {
        $data = $this->entityManager->getRepository(VenueEntity::class)->findOneBy(['id'=>$id]);
        if ($data === null) {
            return;
        }
        return $data->toArray();
    }

    public function getAllVenues()
    {
        $data = $this->entityManager->getRepository(VenueEntity::class)->findAll();
        if ($data === null) {
            return;
        }
        $venues = $this->convertItemsToArray($data);
        $kVenues = [];
        foreach ($venues as $venue) {
            $kVenues[$venue['id']] = $venue;
        }
        return $kVenues;
    }

    public function getVenueDetails(int $id)
    {
        $venue = $this->entityManager->getRepository(VenueEntity::class)->findOneBy(['id'=>$id]);
        return $venue->toArray();
    }
}