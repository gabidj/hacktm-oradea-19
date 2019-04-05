<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/5/2019
 * Time: 11:39 PM
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = require __DIR__ .'/container.php';

return new HelperSet([
    'em' => new EntityManagerHelper(
        $container->get(EntityManager::class)
    ),
]);


