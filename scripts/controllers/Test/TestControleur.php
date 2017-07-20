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
class TestControleur
{
    public function executeTest()
    {
        $logger = Application::getInstance()->getLogger();
        $elusionne = Bot::getInstance();
        $logger->addDebug('tata');
        $elusionne->privateMessage("tenshi002", "le routage 2 fonctionne tres bien");
        $logger->addDebug('toto');
//        echo 'le routage fonctionne très bien';
    }


}