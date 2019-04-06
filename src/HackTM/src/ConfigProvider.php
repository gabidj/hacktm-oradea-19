<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/5/2019
 * Time: 11:32 PM
 */

namespace Oradea\HackTM;

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Oradea\HackTM\Controller\ApiCategoryController;
use Oradea\HackTM\Controller\ApiCategoryControllerFactory;
use Oradea\HackTM\Controller\CategoryController;
use Oradea\HackTM\Controller\CategoryControllerFactory;
use Oradea\HackTM\Controller\HackTmController;
use Oradea\HackTM\Controller\HackTmControllerFactory;
use Oradea\HackTM\Service\HackTmService;
use Oradea\HackTM\Service\HackTmServiceFactory;

class ConfigProvider
{
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine' => $this->getDoctrineEntities(),
        ];

    }

    public function getDependencies() : array
    {
        return [
            'factories'  => [
                EntityManager::class => EntityManagerFactory::class,
                HackTmController::class => HackTmControllerFactory::class,
                CategoryController::class => CategoryControllerFactory::class,
                ApiCategoryController::class => ApiCategoryControllerFactory::class,
                HackTmService::class => HackTmServiceFactory::class,
            ],
        ];
    }

    public function getDoctrineEntities() : array
    {
        return [
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'Oradea\HackTM\Entity' => 'hacktm_entity',
                    ],
                ],
                'hacktm_entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [__DIR__ . 'Oradea/HackTM/Entity'],
                ],
            ],
        ];
    }
}

