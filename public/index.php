<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;

require '../vendor/autoload.php';

$kernel = new \Nastoletni\Orders\Kernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);