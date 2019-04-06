<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:28 AM
 */

namespace Oradea\HackTM\Service;

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
        $criteriaData = $options['criteria'] ?? [];
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
            if ($data['venueId']) {
                $criteria->andWhere($eb->eq('venueId', $data['venueId']));
            }
        }
        return $criteria;
    }
    public function extractOptionsFromRequest(RequestInterface $request)
    {
        $criteria = [];
        $params = [];
        \parse_str($request->getUri()->getQuery(), $query);

        $date = trim($query['date'] ?? '#NO_OR_INVALID_DATE#');
        if (is_numeric($query['venue'] ?? '')) {
            $criteria['venueId'] = (int)($query['venue']);
        }

        if ($this->getDateFromStringWithFormat($date)) {
            $params['dateStart'] = date('Y-m-d H:i:s', strtotime($date));
            $params['dateEnd'] = date('Y-m-d H:i:s', strtotime($date . ' +1 day'));
        }

        $options = [
            'criteria' => $criteria,
            'params' => $params
        ];
        return $options;
    }
}
