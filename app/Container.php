<?php

class Container // список зависимостей
{
    private array $services;

//    public function has(string $className): bool
//    {
//        return isset($this->services[$className]);
//    }
    public function set(string $className, callable $callback): void
    {
        $this->services[$className] = $callback;
    }

    public function get(string $className): object
    {
        if (!isset($this->services[$className])) {
            return new $className;
        }

        $callback = $this->services[$className];

        return $callback($this); //callback function in index.php has argument such as Container $container, so we should peredavat' argument when calling function. $this is the $container
    }
}