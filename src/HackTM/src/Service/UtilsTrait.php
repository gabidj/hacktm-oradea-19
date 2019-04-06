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
use Psr\Http\Message\RequestInterface;
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

    public function isDateValidWithFormat($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    public function getCleanQuery(RequestInterface $request)
    {
        $cleanQuery = [];
        $intKeys = ['venue', 'venueId'];
        $dateKeys = ['date'];
        $dateTimeKeys = ['appointmentDate'];

        \parse_str($request->getUri()->getQuery(), $query);

        foreach ($intKeys as $key) {
            if (is_numeric($query[$key] ?? '')) {
                $cleanQuery[$key] = (int)($query[$key]);
            }
        }
        foreach ($dateKeys as $key) {
            // hackish date cleaning
            $date = trim($query[$key] ?? '#NO_OR_INVALID_DATE#');
            // $date = str_replace('_', ' ', $date);
            if ($this->isDateValidWithFormat($date, 'Y-m-d')) {
                $cleanQuery[$key] = $query[$key];
            }
        }
        foreach ($dateTimeKeys as $key) {
            // hackish date cleaning
            $date = trim($query[$key] ?? '#NO_OR_INVALID_DATE#');
            // $date = str_replace('_', ' ', $date);
            if ($this->isDateValidWithFormat($date, 'Y-m-d H:i:s')) {
                $cleanQuery[$key] = $query[$key];
            }
        }

        return $cleanQuery;
    }
}