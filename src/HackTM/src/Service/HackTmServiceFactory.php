<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 12:57 AM
 */

namespace Oradea\HackTM\Service;


use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Helper\ServerUrlHelper;

class HackTmServiceFactory
{
    public function __invoke(ContainerInterface $container) : HackTmService
    {
        return new HackTmService(
            $entityManager = $container->get(EntityManager::class),
            $urlHelper = $container->get(ServerUrlHelper::class)
        );
    }
}
