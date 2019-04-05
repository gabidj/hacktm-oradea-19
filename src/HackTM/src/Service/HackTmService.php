<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:28 AM
 */

namespace Oradea\HackTM\Service;

use Doctrine\ORM\EntityManager;
use Zend\Expressive\Helper\ServerUrlHelper;

class HackTmService
{
    protected $entityManager;
    protected $urlHelper;
    protected $entityRepository;

    public function __construct(EntityManager $entityManager, ServerUrlHelper $urlHelper)
    {
        $this->entityManager = $entityManager;
        $this->urlHelper = $urlHelper;
    }

}