<?php

namespace lib\bot;

use lib\Application;
use lib\Commandes;
use lib\Moderations;
use Phergie\Irc\Parser;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 08/03/17
 * Time: 09:13
 */
class ircParser
{
    private $phergieParser;
    private $logger;
    private $commandeCaractere;
    //TODO Refaire le traitement des commandes
    private $commandes;
    private $moderation;

    public function __construct()
    {
        $this->logger = Application::getInstance()->getLogger();
        //TODO A intégrer dans le configurateur
//        $this->commandeCaractere = Application::getInstance()->getConfigurateur('commande.caractere');
        $this->commandeCaractere = '~';
        //TODO Refaire le traitement des commandes
        $this->commandes = Commandes::getInstance();
        $this->moderation = Moderations::getInstance();
        $this->phergieParser = new Parser();


        //TODO récupérér le configurateur de moderation

    }

    public function checkMessage($donnees)
    {
        $donneesExplode = $this->getPhergieParser()->parse($donnees);
        $this->logger->addDebug('mon message');
        $this->logger->addDebug(print_r($donneesExplode, true));

        $user = $donneesExplode['user'];
        $text = $donneesExplode['params']['text'];

        //On détecte si c'est une commande ou non
        $regexCommande = '^' . $this->commandeCaractere . '([a-z])+';

        if(preg_match('/' . $regexCommande . '/', trim($text)))
        {
            $datas = array();
            $this->logger->addDebug('On execute la commande');
            $textExplode = explode(' ', trim($text));
            // on s�pare la commande et les arguments
            $nameCommande = array_splice($textExplode, 0, 1);
            // on ajoute l'utilisateur en premier element des arguments
            $datas['nameCommand'] = substr($nameCommande[0], 1);
            $datas['user'] = $user;
            $datas['datas'] = $textExplode;

            $this->commandes->getCommandes($datas['nameCommand'], $datas);
        }

        // Ce n'est pas une commande mais juste du texte
        // 1 - on modère le texte :
        if(Moderations::getStatusAntiLink() === 1)
        {
            $status = $this->moderation->antiLink($text);
            if($status)
            {
                //on time out le viewer
            }
        }

        // 2 - filtre anti-majuscule
        if(Moderations::getStatusAntiSpamUppercase() === 1)
        {
            $status = $this->moderation->antiSpam($text);
            if($status)
            {
                //on time out le viewer
            }
        }
    }

    /**
     * @return Parser
     */
    public function getPhergieParser()
    {
        return $this->phergieParser;
    }


}