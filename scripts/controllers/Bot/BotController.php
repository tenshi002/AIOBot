<?php

namespace controllers\Bot;

use lib\Application;
use lib\bot\Bot;
use lib\Controller;

class BotController extends Controller
{

    public function executeInitSocket()
    {
        Bot::getInstance()->start();
        $this->redirect('Dashboard', 'Index');
    }

    public function executeJoinChannel()
    {
        //A completer
        $bot = Bot::getInstance();
        $session = Application::getInstance()->getSession();
        $user = $session->getUser();

        $bot->joinChannel($user);
        $bot->writeMessage('/me a rejoint le salon wallah');

        $this->redirect('Dashboard', 'Index');
    }
}