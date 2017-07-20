<?php

namespace lib\bot;

use lib\Application;
use lib\bot\ircParser;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 07/03/17
 * Time: 15:26
 */
class Bot
{
    private static $instance = null;
    private $application;
    private $serveurHostName;
    private $port;
    private $password;
    private $nickname;
    private $username;
    private $channel;
    private $socket;
    private $ircParser;

    /**
     * @var Logger
     */
    private $logger;
    private $pathLogger = __DIR__ . '/../../../logs';

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            Application::getInstance()->getLogger()->addDebug('le bot n\'est pas instancie');
            self::$instance = new Bot();
        }
        Application::getInstance()->getLogger()->addDebug('Le bot est instancie');
        return self::$instance;
    }

    private function __construct()
    {
        $this->application = Application::getInstance();
        $this->serveurHostName = $this->application->getConfigurateur('irctwitch.serveurHostName');
        $this->port = $this->application->getConfigurateur('irctwitch.port');
        $this->password = $this->application->getConfigurateur('irctwitch.password');
        $this->nickname = $this->application->getConfigurateur('irctwitch.nickname');
        $this->username = $this->application->getConfigurateur('irctwitch.username');
        $this->channel = $this->application->getConfigurateur('irctwitch.channel');
        $this->logger = new Logger('bot');
        $this->logger->pushHandler(new StreamHandler($this->getPathLogger() . '/botLog.txt'));
        $this->ircParser = new ircParser();

        $this->connexionServeur();
    }

    /**
     * On récupère les informations envoyé au serveur
     */
    public function iniConnexion()
    {
        set_time_limit(0);
        $continuer = 1;
        while($continuer) // Boucle pour la connexion.
        {
            $donnees = fgets($this->getSocket(), 1024);
            $retour = explode(':', $donnees);
            if(rtrim($retour[0]) == 'PING')
            {
                $this->logger->addInfo('Twitch demande le pong  : ' . $retour[1]);
                fwrite($this->getSocket(), 'PONG :' . $retour[1]);
            }

            if($donnees)
            {
                // on log les retours du serveur irc
                $this->logger->addInfo($donnees);
                $this->ircParser->checkMessage($donnees);
            }

            if(preg_match('#:(.+):End Of /NAMES list.#i', $donnees))
            {
                $this->writeMessage("Je suis à votre service Maitre.");
            }
        }
    }

    /**
     * Le bot quitte le chat
     */
    public function leaveChannel()
    {
        Application::getInstance()->getLogger()->addInfo('on quitte le channel : ' . $this->getChannel());
        fwrite($this->getSocket(), "PART " . $this->getChannel() . "\r\n");
    }

    /**
     * Ecrit un message dans le chat
     * @param $message
     */
    public function writeMessage($message)
    {
        fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :" . utf8_encode($message) . "\r\n");
    }

    /**
     * Envoie d'un mp au destinataire passé en paramètre
     * @param $destinataire string pseudo du destinataire
     * @param $message string message à envoyer
     */
    public function privateMessage($destinataire, $message)
    {
        Application::getInstance()->getLogger()->addError("PRIVMSG " . $this->getChannel() . " :/w " . $destinataire . " " . utf8_encode($message) . "\r\n");
        fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :/w " . $destinataire . " " . utf8_encode($message) . "\r\n");
    }

    /**
     *
     */
    private function connexionServeur()
    {
        $this->setSocket(fsockopen($this->getServeurHostName(), $this->getPort(), $errno, $errstr, 30));
        if(!$this->getSocket())
        {
            //TODO créer un logeur
            $this->logger->addError("echec de la connexion irc\r\n");
            exit();
        }
        fwrite($this->getSocket(), "PASS " . $this->getPassword() . "\r\n");
        fwrite($this->getSocket(), "USER " . $this->getUsername() . $this->getUsername() . " tati toto\r\n");
        fwrite($this->getSocket(), "NICK " . $this->getNickname() . "\r\n");
        fwrite($this->getSocket(), "JOIN " . $this->getChannel() . "\r\n");
    }

    /**
     * @return bool|string
     */
    public function getServeurHostName()
    {
        return $this->serveurHostName;
    }

    /**
     * @return bool|string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return bool|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool|string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return bool|string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @param mixed $socket
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    /**
     * @return string
     */
    public function getPathLogger()
    {
        return $this->pathLogger;
    }


}