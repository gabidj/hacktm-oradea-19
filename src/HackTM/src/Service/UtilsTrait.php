<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:28 AM
 */

namespace Oradea\HackTM\Service;

use Doctrine\ORM\EntityManager;
use Oradea\HackTM\Entity\SportEntity;
use Zend\Expressive\Helper\ServerUrlHelper;
use DateTime;

trait UtilsTrait
{
    /* @var HackTmService $this */
    public function convertItemsToArray($items = [])
    {
        $items = $items ?? [];
        if (is_object($items)) {
            $items = $items->toArray();
        }
        // hack-ish version to convert entities to array
        foreach ($items as $k => $v) {
            $items[$k] = $v->toArray();
        }
        return $items;
    }

    public function getDateFromStringWithFormat($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
}