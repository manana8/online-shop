<?php

class Autoloader
{
    public static function registrate(string $dir)
    {
        $autoload = function (string $className) use ($dir) {
            $path = str_replace('\\', '/', $className);
            $path = $dir . "/" . $path . ".php";
//            print_r($dir); die();

            if (file_exists($path)) {
                require_once $path;
            }
        };

        spl_autoload_register($autoload);
    }
}