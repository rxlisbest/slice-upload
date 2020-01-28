<?php
class Autoloader
{
    public static function myAutoload($name)
    {
        $class_path = end(explode('\\', $name));
        $file = '../src/' . $class_path . '.php';
        if (file_exists($file)) {
            require_once($file);
            if (class_exists($name, false)) {
                return true;
            }
        }
        $file = '../src/Request/' . $class_path . '.php';
        if (file_exists($file)) {
            require_once($file);
            if (class_exists($name, false)) {
                return true;
            }
        }
        return false;
    }
}

spl_autoload_register('Autoloader::myAutoload');