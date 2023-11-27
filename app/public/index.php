<?php

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login') {
    require_once './handler/login.php';
} elseif ($requestUri === '/registrate') {
    require_once './handler/registrate.php';
} elseif ($requestUri === '/main-page') {
    require_once './handler/main.php';
} elseif ($requestUri === '/add-product') {
    require_once './handler/add-product.php';
} else {
    echo 'The page is not founded';
}
