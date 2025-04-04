<?php

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection([
    'driver' => 'pgsql',
    'host' => 'docker.postgres',
    'port' => 5432,
    'database' => 'pdb',
    'username' => $_ENV['POSTGRES_USER'],
    'password' => 'ppassword',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();