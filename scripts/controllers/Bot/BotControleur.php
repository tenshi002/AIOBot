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

class BotControleur extends Controller
{

    public function executeJoinChannel()
    {
        //A completer
        $bot = Bot::getInstance()->getInstance();

        $twitchAccount = 'tata';

        $bot->joinChannel($twitchAccount);
        $bot->writeMessage('/me a rejoint le salon');
    }
}