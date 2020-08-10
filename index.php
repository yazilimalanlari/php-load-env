<?php

require __DIR__ . '/src/ENV.php';



$env = new ENV(__DIR__ . '/.env');
$env->init();


switch (ENV::get('MODE')) {
    case "development":
        $env->load(__DIR__ . '/.development.env');
        break;
    case "production":
        $env->load(__DIR__ . '/.production.env');
        break;
}

echo ENV::get('DB_NAME');