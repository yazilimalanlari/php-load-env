<?php

require __DIR__ . '/src/ENV.php';



$env = new ENV(__DIR__ . '/.env');
$env->init();
// $env->load();

echo ENV::get('NUMBER');