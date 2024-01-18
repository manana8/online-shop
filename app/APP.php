<?php

use Request\Request;
use Service\LoggerService;

class APP
{
    private Container $container;
    private LoggerService $loggerService;
    private array $routes = [];
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

//                if ($this->container->has($class)) {
//                    $obj = $this->container->get($class); // If method 'has' exists
//                } else {
//                    $obj = new $class();
//                }

                $obj = $this->container->get($class);

                if (empty($handler['request'])) {
                    $request = new Request($requestMethod, $_POST);
                } else {
                    $requestClass = $handler['request'];
                    $request = new $requestClass($requestMethod, $_POST);
                }

                try {
                    $obj->$method($request);
                } catch (Error $error) {
//                    $loggerService = new LoggerService();
                    $this->loggerService->error($error);

                    require_once '../View/error500.html';
                }

            } else {
                echo "The method $requestMethod for $requestUri is not supported!";
            }

        } else {
            require_once '../View/error404.html';
        }
    }

    public function get(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['GET'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function post(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['POST'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function put(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['PUT'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function patch(string $name, string $className, string $method, string $request = null): void
    {
        $this->routes[$name]['PATCH'] =
            [
                'class' => $className,
                'method' => $method,
                'request' => $request,
            ];
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
        $this->LoggerService = $container->get(LoggerService::class);
    }
}