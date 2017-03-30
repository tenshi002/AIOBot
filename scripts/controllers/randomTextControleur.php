<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:00
 */

namespace controllers;


use CommandsTexts;
use lib\bot\Bot;

class randomText
{

    public function randomText($args)
    {
        $elusionne = Bot::getInstance();
        $commandsTexts = new CommandsTexts();
        $commandstext = $commandsTexts->getCommandTextByName($args[0]);
        $texts = $commandstext->getTexts();

        $randomInt = random_int(0, count($texts) - 1 );
        $randomText = $texts[$randomInt];

        $elusionne->writeMessage($randomText->getText());
    }
}