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
use lib\Controller;
use lib\Session;

class BotControleur extends Controller
{

    public function executeInitSocket()
    {
        $bot = Bot::getInstance()->getInstance();
    }

    public function executeJoinChannel()
    {
        //A completer
        $bot = Bot::getInstance()->getInstance();
        $session = Application::getInstance()->getSession();
        $user = $session->getUser();

        $bot->joinChannel($user);
        $bot->writeMessage('/me a rejoint le salon wallah');

        $this->redirect('Dashboard', 'Index');
    }
}