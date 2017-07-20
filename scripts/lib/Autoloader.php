<?php

namespace lib;

class Autoloader
{
    /**
     * Enregistre notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclue le fichier correspondant � notre classe
     * @param $class string Le nom de la classe � charger
     */
    static function autoload($class){
        require './scripts/' . str_replace('\\','/',$class) . '.php';
    }

}