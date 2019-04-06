<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:28 AM
 */

namespace Oradea\HackTM\Service;

use DateTime;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ExpressionBuilder;
use Doctrine\ORM\EntityManager;
use Oradea\HackTM\Entity\AppointmentEntity;
use Oradea\HackTM\Entity\SportEntity;
use Psr\Http\Message\RequestInterface;
use Zend\Expressive\Helper\ServerUrlHelper;

trait AppointmentsTrait
{
    use UtilsTrait;

    /* @var HackTmService $this */
    public function listAppointments(array $options = [])
    {
        $criteriaData = $options['criteriaData'] ?? [];
        $criteria = $this->buildCriteria($criteriaData);
        /* @var HackTmService $this */
        $appointments = $this->entityManager->getRepository(AppointmentEntity::class)->matching($criteria);
        $appointments->toArray();
        $appointments = $this->convertItemsToArray($appointments);
        return $appointments;
    }

    public function buildCriteria($data)
    {
        $eb = new ExpressionBuilder();
        $criteria = new Criteria();
        $criteria->where($eb->neq('id', '0'));
        foreach ($data as $key => $value) {
            if (isset($data['venueId'])) {
                $criteria->andWhere($eb->eq('venueId', $data['venueId']));
            }
            if (isset($data['dateStart'], $data['dateEnd'])) {
                $dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $data['dateStart']);
                $dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $data['dateEnd']);
                $criteria->andWhere($eb->gte('date', $dateStart));
                $criteria->andWhere($eb->lte('date', $dateEnd));
            }
        }
        return $criteria;
    }
    public function extractOptionsFromRequest(RequestInterface $request)
    {
        $criteria = [];
        $criteriaData = [];
        \parse_str($request->getUri()->getQuery(), $query);

        $date = trim($query['date'] ?? '#NO_OR_INVALID_DATE#');
        if (is_numeric($query['venue'] ?? '')) {
            $criteria['venueId'] = (int)($query['venue']);
        }

        if ($this->isDateValidWithFormat($date)) {
            $criteriaData['dateStart'] = date('Y-m-d H:i:s', strtotime($date));
            $criteriaData['dateEnd'] = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
        }

        $options = [
            'criteria' => $criteria,
            'criteriaData' => array_merge($criteria, $criteriaData)
        ];
        return $options;
    }
}
