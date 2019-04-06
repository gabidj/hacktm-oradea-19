<?php
/**
 * User: gabidj
 * Date: 2019-04-06
 * Time: 14:35
 */

namespace Oradea\HackTM\Cors;

use Tuupola\Middleware\CorsMiddleware;
use Zend\Diactoros\Response;
use Zend\Stratigility\Middleware\CallableMiddlewareDecorator;

class CorsMiddlewareFactory
{
    public function __invoke($container)
    {
        return new CorsMiddleware([
                "origin" => ["*"],
                "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
                "headers.allow" => ["Content-Type", "Accept"],
                "headers.expose" => [],
                "credentials" => false,
                "cache" => 0,
            ]
        );
    }
}
