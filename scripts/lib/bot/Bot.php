<?php

namespace lib\bot;

use lib\Application;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Phergie\Irc\Parser;


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
    private $sendMessage = null;

    /**
     * @var Logger
     */
    private $logger;
    private $pathLogger = __DIR__ . '/../../../logs';

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Bot();
        }
        return self::$instance;
    }

    public function __construct()
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
    }

    public function iniConnexion()
    {
        set_time_limit(0);

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

        $continuer = 1;
        while($continuer) // Boucle pour la connexion.
        {
            $donnees = fgets($this->getSocket(), 1024);
            $retour = explode(':', $donnees);
            if(rtrim($retour[0]) == 'PING')
            {
                fwrite($this->getSocket(), 'PONG :' . $retour[1]);
            }
            flush();

            if($donnees)
            {
                // on log les retours du serveur irc
                $this->logger->addInfo($donnees);
            }

            if(preg_match('#:(.+):End Of /NAMES list.#i', $donnees))
            {
                $continuer = 0;
                $this->writeMessage("Je suis à votre service Maitre.");
            }
            $sendMessage = $this->getSendMessage();
            if(isset($sendMessage) && !is_null($sendMessage))
            {
                $this->logger->addInfo('ya un msg');
                $this->writeMessage($sendMessage);
            }
        }
    }


    public function readChat()
    {
        $phergieParser = new Parser();
        while(!feof($this->getSocket()))
        {
            $donnees = fgets($this->getSocket(), 1024);
            $retour = explode(':', $donnees);
            $message = $phergieParser->parse($donnees);
            flush();

            if(rtrim($retour[0]) == 'PING')
            {
                fwrite($this->getSocket(), 'PONG :' . $retour[1]);
            }

            if($donnees)
            {
                $this->logger->addInfo($message['params']['text']);
            }
            $sendMessage = $this->getSendMessage();
            if(isset($sendMessage) && !is_null($sendMessage))
            {
                $this->logger->addInfo('ya un msg');
                $this->writeMessage($sendMessage);
            }
        }
    }

    public function writeMessage($message)
    {
        fwrite($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :" . $message . "\r\n");
    }

    /**
     * @param $destinataire string pseudo du destinataire
     * @param $message string message à envoyer
     */
    public function privateMessage($destinataire, $message)
    {
        fwrite($this->getSocket(), "NOTICE #" . $destinataire . " :" . $message . "\r\n");
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

    /**
     * @return mixed
     */
    public function getSendMessage()
    {
        return $this->sendMessage;
    }

    /**
     * @param mixed $sendMessage
     */
    public function setSendMessage($sendMessage)
    {
        Application::getInstance()->getLogger()->addDebug('on prepare le message');
        $this->sendMessage = $sendMessage;
    }


}