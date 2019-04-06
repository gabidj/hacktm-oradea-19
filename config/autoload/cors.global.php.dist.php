<?php
/**
 * User: gabidj
 * Date: 2019-04-06
 * Time: 15:18
 */

return [
    'cors' => [
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => ["Content-Type", "Accept"],
        "headers.expose" => [],
        "credentials" => false,
        "cache" => 0,
    ]
];
