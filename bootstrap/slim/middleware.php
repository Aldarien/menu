<?php
$app->add(new App\Middleware\Benchmark($app));
$app->add(new Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware($app));
$app->add(new App\Middleware\Migrator($app));
