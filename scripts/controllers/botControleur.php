<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 13/03/17
 * Time: 16:14
 */

namespace controllers;

use lib\bot\Bot;

class botControleur
{

    public function executeInitConnexion()
    {
        $bot = Bot::getInstance();
        $bot->iniConnexion();
        $bot->readChat();
    }

}