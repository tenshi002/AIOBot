<?php

namespace lib;

class Autoloader
{
    /**
     * Enregistre notre autoloader
     */
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant à notre classe
     *
     * @param $class string Le nom de la classe à charger
     */
    static function autoload($class)
    {
        if(class_exists($class))
        {
            return;
        }
        $path = __DIR__ . '/../../scripts/' . str_replace('\\', '/', $class) . '.php';
        if(file_exists($path))
        {
            require_once $path;
        }
    }

}