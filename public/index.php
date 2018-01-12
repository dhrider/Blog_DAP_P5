<?php

use Symfony\Component\HttpFoundation\Request;
use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Debug\Debug;

require __DIR__.'/../vendor/autoload.php';

if (!isset($_SERVER['APP_ENV'])) {
    (new Dotenv())->load(__DIR__.'/../.env');
}

if ($_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev'))) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel('prod', false);

//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', $_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev')));
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
