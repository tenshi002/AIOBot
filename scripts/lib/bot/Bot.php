<?php

namespace lib\bot;

use lib\Application;
use lib\Async\PhpTask;
use modeles\User;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 07/03/17
 * Time: 15:26
 */
class Bot extends PhpTask
{
    private static $instance = null;
    private static $botName;
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
            self::$instance = new Bot();
        }
        return self::$instance;
    }

    public function run()
    {
        if($this->isRunning())
        {
            return;
        }
        $this->initSocket();
    }

    public function __construct($statusFilename = null)
    {
        parent::__construct($statusFilename);

        $this->application = Application::getInstance();
        $this->serveurHostName = $this->application->getConfigurateur('irctwitch.serveurHostName');
        $this->port = $this->application->getConfigurateur('irctwitch.port');
        $this->password = $this->application->getConfigurateur('irctwitch.password');
        $this->nickname = $this->application->getConfigurateur('irctwitch.nickname');
        $this->username = $this->application->getConfigurateur('irctwitch.username');
        self::$botName = $this->application->getConfigurateur('irctwitch.username');

        // On log l'intégralité des échanges Clients <-> Serveur twitch
        $this->logger = new Logger('bot');
        $this->logger->pushHandler(new StreamHandler($this->getPathLogger() . '/botLog.txt'));

        // initialisation du parser de message
        $this->ircParser = new ircParser();
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
            //limitation du temps entre chaque message envoyé au serveur
            //Pour les modos c'est 100 et les classiques 20
            sleep(1 / (100 / 30));
        }
    }

    /**
     * Permet de joindre les channels
     *
     * @param User $user
     */
    public function joinChannel(User $user)
    {
        Application::getInstance()->getLogger()->addInfo('on rejoind le channel : ' . $this->getChannel());
        fwrite($this->getSocket(), "JOIN #" . $user->getTwitchAccount() . "\r\n");
    }

    /**
     * Le bot quitte le chat
     * il peut arriver qu'il apparaisse encore dans la liste des viewers mais c'est normal
     * le temps que twitch actualise
     *
     * @param User $user
     */
    public function leaveChannel(User $user)
    {
        Application::getInstance()->getLogger()->addInfo('on quitte le channel : ' . $this->getChannel());
        fwrite($this->getSocket(), "PART #" . $user->getTwitchAccount() . "\r\n");
    }

    /**
     * Ecrit un message dans le chat
     *
     * @param $message
     */
    public function writeMessage($message)
    {
        fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :" . utf8_encode($message) . "\r\n");
    }

    public function timeoutViewer($pseudo, $time = 1)
    {
        Application::getInstance()->getLogger()->addError("PRIVMSG " . $this->getChannel() . " :/timeout " . $pseudo . " " . utf8_encode($time) . "\r\n");
        fputs($this->getSocket(), "CLEARCHAT " . $this->getChannel() . " :" . utf8_encode($pseudo) . " @ban-duration=" . $time . "\r\n");
        // ou
        //fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :/timeout " . utf8_encode($pseudo) . " " . $time . "\r\n");
    }

    public function ban($pseudo)
    {
        Application::getInstance()->getLogger()->addError("PRIVMSG " . $this->getChannel() . " :/ban " . $pseudo . "\r\n");
        fputs($this->getSocket(), "CLEARCHAT " . $this->getChannel() . " :" . utf8_encode($pseudo) . "\r\n");
        // ou
        //fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :/ban " . utf8_encode($pseudo) . "\r\n");
    }

    /**
     * Envoie d'un mp au destinataire passé en paramètre
     *
     * @param $destinataire string pseudo du destinataire
     * @param $message string message à envoyer
     */
    public function privateMessage($destinataire, $message)
    {
        Application::getInstance()->getLogger()->addError("PRIVMSG " . $this->getChannel() . " :/w " . $destinataire . " " . utf8_encode($message) . "\r\n");
        fputs($this->getSocket(), "PRIVMSG " . $this->getChannel() . " :/w " . $destinataire . " " . utf8_encode($message) . "\r\n");
    }

    /**
     * On ouvre le socket vers twitch
     */
    private function initSocket()
    {
        $this->setSocket(fsockopen($this->getServeurHostName(), $this->getPort(), $errno, $errstr, 30));
        stream_set_blocking($this->socket, false);
        if(!$this->getSocket())
        {
            //TODO créer un logeur
            $this->logger->addError("echec de la connexion irc\r\n");
            exit();
        }
        fwrite($this->getSocket(), "PASS " . $this->getPassword() . "\r\n");
        fwrite($this->getSocket(), "USER " . $this->getUsername() . $this->getUsername() . " tati toto\r\n");
        fwrite($this->getSocket(), "NICK " . $this->getNickname() . "\r\n");

        //Par défaut on rejoind le channel du bot
        fwrite($this->getSocket(), "JOIN #" . $this->getUsername() . "\r\n");

        //On active les droits de départ pour les membres twitch
        fwrite($this->getSocket(), "CAP REQ :twitch.tv/membership\r\n");

        $this->iniConnexion();
//        $this->writeMessage('HI !');
    }

    /**
     * On ferme le socket
     */
    public function closeSocket()
    {
        fclose($this->socket);
    }

    public static function getBotName()
    {
        return self::$botName;
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