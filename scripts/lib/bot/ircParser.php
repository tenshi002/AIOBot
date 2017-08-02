<?php

namespace lib\bot;

use lib\Application;
use lib\Commandes;
use lib\Moderations;
use modeles\User;
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
    private $entityManager;
    private $userRepository;
    private $session;

    public function __construct()
    {
        $this->logger = Application::getInstance()->getLogger();
        $this->entityManager = Application::getInstance()->getEntityManager();
        $this->session = Application::getInstance()->getSession();
        $this->userRepository = $this->entityManager->getRepository('modeles\User');
        //TODO A intégrer dans le configurateur
//        $this->commandeCaractere = Application::getInstance()->getConfigurateur('commande.caractere');
        $this->commandeCaractere = '~';
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

        $viewerName = $donneesExplode['user'];
        $text = $donneesExplode['params']['text'];

        //On détecte si c'est une commande ou non
        $regexCommande = '^' . $this->commandeCaractere . '([a-z])+';


        //<editor-fold desc="Detection d'une commande">
        if(preg_match('/' . $regexCommande . '/', trim($text)))
        {
            $datas = array();
            $this->logger->addDebug('On execute la commande');
            $textExplode = explode(' ', trim($text));
            // on s�pare la commande et les arguments
            $nameCommande = array_splice($textExplode, 0, 1);
            // on ajoute l'utilisateur en premier element des arguments
            $datas['nameCommand'] = substr($nameCommande[0], 1);
            $datas['user'] = $viewerName;
            $datas['datas'] = $textExplode;

            $this->commandes->getCommandes($datas['nameCommand'], $datas);
        }
        //</editor-fold>

        //
        $this->moderation($viewerName, $text);

    }

    private function moderation(User $viewerName, $text)
    {
        /** @var $streamerName User*/
        $streamerName = $this->userRepository->findOneBy(array('twitchAccount', $this->session->get('twitchAccount')));
        /** @var $viewer User*/
        $viewer = $this->userRepository->findOneBy(array('twitchAccount', $viewerName));
        // Ce n'est pas une commande mais juste du texte
        // 1 - on modère le texte :
        if($streamerName->getBotAntiLink() && !$viewer->getPermitLink())
        {
            $status = $this->moderation->antiLink($streamerName, $text);
            if($status)
            {
                //on time out le viewer
                Bot::getInstance()->timeoutViewer($viewer->getTwitchAccount());
            }
        }
        if($viewer->getPermitLink())
        {
            $viewer->setPermitLink(false);
        }

        // 2 - filtre anti-majuscule
        if($streamerName->getBotAntiSpam() === 1)
        {
            $status = $this->moderation->antiSpam($text);
            if($status)
            {
                //on time out le viewer
                Bot::getInstance()->timeoutViewer($viewer->getTwitchAccount());
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