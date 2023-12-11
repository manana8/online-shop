<?php

//Autoloader::regisrtrate();

$autoload = function (string $className) {
    $path = str_replace('\\', '/', $className);
    $path = dirname(__DIR__) . "/" . $path . ".php";

    if (file_exists($path)) {
        require_once $path;
    }
};

spl_autoload_register($autoload);

$app = new APP();
$app->run();
