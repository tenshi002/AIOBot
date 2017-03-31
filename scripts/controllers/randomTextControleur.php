<?php
/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 31/03/2017
 * Time: 00:00
 */

namespace controllers;

use lib\Application;
use lib\bot\Bot;
use modeles\CommandsTexts\CommandsTexts;

class randomTextControleur
{

    public function executeRandomTexts($args)
    {
        $logger = Application::getInstance()->getLogger();
        $elusionne = Bot::getInstance();
        $commandName = $args[0];
        $user = $args[1];
        $destinataires = implode(', ', array_splice($args, 2, count($args) - 1));


        $commandsTexts = new CommandsTexts();
        $commandsText = $commandsTexts->getCommandTextByName($args[0]);
        $texts = $commandsText->getTexts();
        if(is_array($texts) && !empty($texts))
        {
            if(count($texts) === 1)
            {
                $randomText = $texts[0];
            }
            else
            {
                $randomInt = random_int(0, count($texts) - 1 );
                $randomText = $texts[$randomInt];
            }
            $elusionne->writeMessage(sprintf($randomText->getText(), $user, $destinataires));
        }

    }

    public function executeGenerateMultitwitch($args)
    {
        $logger = Application::getInstance()->getLogger();
        $elusionne = Bot::getInstance();
        $multitwitcher = "";
        $commandName = $args[0];
        $user = $args[1];
        $destinatairesExtract = array_splice($args, 2, count($args) - 1);

        $commandsTexts = new CommandsTexts();
        $commandsText = $commandsTexts->getCommandTextByName($args[0]);
        $texts = $commandsText->getTexts();
        $destinatairesMulti = implode('/', $destinatairesExtract);
        foreach($destinatairesExtract as $key => $destinataire)
        {
            if($key < count($destinatairesExtract) - 1)
            {
                $multitwitcher .= $destinataire . ', ';
            }
            else
            {
                $multitwitcher .= ' et ' . $destinataire;
            }
        }
        $elusionne->writeMessage(sprintf($texts[0]->getText() . $destinatairesMulti, $user, $multitwitcher));
    }
}