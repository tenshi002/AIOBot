<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 13/03/17
 * Time: 16:14
 */

namespace controllers;

use lib\Application;
use lib\bot\Bot;
use lib\Commandes;

class botControleur
{

    public function executeInitConnexion()
    {
        $bot = Bot::getInstance();
        $bot->iniConnexion();
    }

    public function executeGetCommands($args)
    {
        $elusionne = Bot::getInstance();
        $listeCommande = Commandes::getInstance()->getListeCommands();
        $commandsList = '';
        foreach($listeCommande as $commandeName)
        {
            $commandsList = $commandsList . $commandeName . " | ";
            Application::getInstance()->getLogger()->addDebug($commandsList);
        }
        $elusionne->privateMessage($args[1], $commandsList);
    }

    public function executeQuit()
    {
        $logger = Application::getInstance()->getLogger();
        $elusionne = Bot::getInstance();
        $elusionne->writeMessage('A bientot Maitre');
        $elusionne->leaveChannel();
        $logger->addInfo('le bot a quitte le channel');
    }
}