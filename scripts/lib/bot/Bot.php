<?php

namespace lib\bot;

use lib\Application;
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
    private static $instance;
    private $application;
    private $serveurHostName;
    private $port;
    private $password;
    private $nickname;
    private $username;
    private $channel;
    private $socket;

    private $logger;

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
//        $this->logger = new Logger();
    }

    public function iniConnexion()
    {
        // le script doit tourner indéfiniement
        set_time_limit(0);

        $this->socket = fsockopen($this->getServeurHostName(), $this->getPort(), $errno, $errstr, 30);
        if(!$this->socket)
        {
            //TODO créer un logeur
            file_put_contents(__DIR__ . '/../../../testBot.txt', "echec de la connexion irc\r\n", FILE_APPEND);
            exit();
        }
        fputs($this->getSocket(), "PASS " . $this->getPassword() . "\r\n");
        fputs($this->getSocket(), "USER " . $this->getUsername() . $this->getUsername() . " tati toto\r\n");
        fputs($this->getSocket(), "NICK " . $this->getNickname() . "\r\n");
        fputs($this->getSocket(), "JOIN " . $this->getChannel() . "\r\n");

        stream_set_timeout($this->getSocket(), 0);

        $continuer = 1;
        while($continuer) // Boucle pour la connexion.
        {
            $donnees = fgets($this->getSocket(), 1024);
            $retour = explode(':', $donnees);
            if(rtrim($retour[0]) == 'PING')
            {
                fputs($this->getSocket(), 'PONG :' . $retour[1]);
            }

            if($donnees)
            {
                file_put_contents(__DIR__ . '/../../../testBot.txt', "steven> " . $donnees . "\r\n", FILE_APPEND);
            }

            if(preg_match('#:(.+):End Of /NAMES list.#i', $donnees))
            {
                $continuer = 0;
                fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :Je suis presente Maitre.\r\n");
            }
        }

    }


    public function readChat()
    {
        $phergieParser = new Parser();
        while(1)
        {
            $donnees = fgets($this->getSocket(), 1024);
            $retour = explode(':', $donnees);
            $message = $phergieParser->parse($donnees);

            if(rtrim($retour[0]) == 'PING')
            {
                fputs($this->getSocket(), 'PONG :' . $retour[1]);
            }

            if($donnees)
            {
                file_put_contents(__DIR__ . '/../../../testBot.txt', "steven> " . $message['params']['text'] . "\r\n", FILE_APPEND);
            }
        }
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


}