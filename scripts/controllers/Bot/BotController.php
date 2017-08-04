<?php

namespace controllers\Bot;

use lib\Application;
use lib\bot\Bot;
use lib\Controller;

class BotController extends Controller
{

    public function executeInitSocket()
    {
        Bot::getInstance()->run();
    }

    public function executeJoinChannel()
    {
        //A completer
        $bot = Bot::getInstance();
        $session = Application::getInstance()->getSession();
        $user = $session->getUserFromSession();

        $bot->joinChannel($user);
        $bot->writeMessage('/me a rejoint le salon wallah');

        $this->redirect('Dashboard', 'Index');
    }
}