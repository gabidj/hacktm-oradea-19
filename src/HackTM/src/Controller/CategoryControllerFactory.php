<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 2:43 AM
 */

namespace Oradea\HackTM\Controller;


use Doctrine\ORM\EntityManager;
use Dot\Authentication\Web\Options\WebAuthenticationOptions;
use Dot\Helpers\Route\RouteHelper;
use Dot\User\Options\UserOptions;
use Oradea\HackTM\Service\HackTmService;
use Psr\Container\ContainerInterface;

class CategoryControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get("config");
        $service = $container->get(HackTmService::class);
        $options = $container->get(UserOptions::class);
        $webAuthenticationOptions = $container->get(WebAuthenticationOptions::class);
        $routeHelper = $container->get(RouteHelper::class);
        $entityManager = $container->get(EntityManager::class);

        return new CategoryController(
            $config,
            $service,
            $options,
            $webAuthenticationOptions,
            $routeHelper,
            $entityManager
        );
    }
}