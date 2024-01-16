<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\Request;

class APP
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLoginForm',
            ],
            'POST'=>[
                'class' => UserController::class,
                'method' => 'postLogin',
                'request' => LoginRequest::class,
            ]
        ],
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrateForm',
            ],
            'POST'=>[
                'class' => UserController::class,
                'method' => 'postRegistrate',
                'request' => RegistrateRequest::class,
            ]
        ],
        '/main-page' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'mainPage',
            ],
            'POST'=> [
                'class' => CartController::class,
                'method' => 'addProduct',
                'request' => AddProductRequest::class,
            ]
        ],
        '/user-cart' => [
            'GET'=> [
                'class' => CartController::class,
                'method' => 'getCart',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderForm',
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'postOrder',
                'request' => OrderRequest::class,
            ]
        ],
        '/order-product' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderProduct',
            ]
        ]
    ];
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        if (isset($this->routes[$requestUri])) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];//GET or POST
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];
                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();
                if (empty($handler['request'])) {
                    $request = new Request($requestMethod, $_POST);
                } else {
                    $requestClass = $handler['request'];
                    $request = new $requestClass($requestMethod, $_POST);
                }

                try {
                    $obj->$method($request);
                } catch (Throwable $throwable) {
                    $file = __DIR__ . '/Storage/logs/error.txt';
                    $data = date('d.m.Y h:i:s');
                    $message = $throwable->getMessage() . '. Внимание на строку ' . $throwable->getLine() . ' в файле ' . $throwable->getFile();

                        file_put_contents($file, $data . "\n" . $message . ";\n", FILE_APPEND);

                    require_once '../View/error500.html';
                }


            } else {
                echo "The method $requestMethod for $requestUri is not supported!";
            }

        } else {
            require_once '../View/error404.html';
        }
    }
}