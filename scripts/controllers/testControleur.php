<?php

namespace controllers;

use lib\bot\Bot;
use lib\Application;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 03/03/17
 * Time: 09:16
 */
class testControleur
{
    public function executeTest()
    {
        $logger = Application::getInstance()->getLogger();
        $elusionne = Bot::getInstance();
        $logger->addDebug('tata');
        $elusionne->setSendMessage("le routage fonctionne très bien");
        $logger->addDebug('toto');
//        echo 'le routage fonctionne très bien';
    }
}