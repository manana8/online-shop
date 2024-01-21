<?php

namespace Service;

use mysql_xdevapi\Warning;

class LoggerService
{
    public function error($error): bool|int
    {
        $file = '../Storage/logs/error.txt';
        $data = date('d.m.Y h:i:s');
        $message = $error->getMessage() . '. Внимание на строку ' . $error->getLine() . ' в файле ' . $error->getFile();

        return file_put_contents($file, $data . "\n" . $message . ";\n", FILE_APPEND);
    }

    public function warning()
    {
        error_reporting(E_WARNING);
    }
}