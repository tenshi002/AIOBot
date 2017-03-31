<?php

namespace lib\bot;

use lib\Application;
use lib\Commandes;
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
    private $commandes;

    public function __construct()
    {
        $this->logger = Application::getInstance()->getLogger();
//        $this->commandeCaractere = Application::getInstance()->getConfigurateur('commande.caractere');
        $this->commandeCaractere = '~';
        $this->commandes = Commandes::getInstance();
        $this->phergieParser = new Parser();

    }

    public function checkMessage($donnees)
    {
        $donneesExplode = $this->getPhergieParser()->parse($donnees);
        $this->logger->addDebug('mon message');
        $this->logger->addDebug(print_r($donneesExplode, true));

        $user = $donneesExplode['user'];
        $text = $donneesExplode['params']['text'];

        $regexCommande = '^' . $this->commandeCaractere . '([a-z])+';

        if(preg_match('/' . $regexCommande . '/', trim($text)))
        {
            $this->logger->addDebug('On execute la commande');
            $textExplode = explode(' ', trim($text));
            // on s�pare la commande et les arguments
            $commande = array_splice($textExplode, 0, 1);
            // on ajoute l'utilisateur en premier element des arguments
            $args = array_merge(array(substr($commande[0], 1), $user), $textExplode);

            $this->commandes->getCommandes(substr($commande[0], 1), $args) ;

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