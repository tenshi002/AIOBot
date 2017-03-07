<?php
use Phergie\Irc\Parser;


/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 07/03/17
 * Time: 15:26
 */
class bot
{
    private $application;
    private $serveurHostName;
    private $port;
    private $password;
    private $nickname;
    private $username;

    public function __construct()
    {
        $this->application = Application::getInstance();
        $this->serveurHostName = $this->application->getConfigurateur('irctwitch.serveurHostName');
        $this->port = $this->application->getConfigurateur('irctwitch.port');
        $this->password = $this->application->getConfigurateur('irctwitch.password');
        $this->nickname = $this->application->getConfigurateur('irctwitch.nickname');
        $this->username = $this->application->getConfigurateur('irctwitch.username');
    }

    public function iniConnexion()
    {
        // le script doit tourner indéfiniement
        set_time_limit(0);

        $socket = fsockopen('irc.chat.twitch.tv', '6667', $errno, $errstr, 30);
        if(!$socket)
        {
            //TODO créer un logeur
            file_put_contents(__DIR__ . '/../../../testBot.txt', "echec de la connexion irc\r\n", FILE_APPEND);
            exit();
        }
        file_put_contents(__DIR__ . '/../../../testBot.txt', "< PASS\r\n", FILE_APPEND);
        fputs($socket, "PASS oauth:cofsyzpg5xkqeqq2cr85dtcui4txb6\r\n");
        file_put_contents(__DIR__ . '/../../../testBot.txt', "< USER\r\n", FILE_APPEND);
        fputs($socket, "USER tenshi002 tenshi002 tati toto\r\n");
        file_put_contents(__DIR__ . '/../../../testBot.txt', "< NICK\r\n", FILE_APPEND);
        fputs($socket, "NICK tenshi002\r\n");
        fputs($socket, "JOIN #tenshi002\r\n");
        stream_set_timeout($socket, 0);
        $continuer = 1;
//        while($continuer)
//        {
//            $donnees = fgets($socket, 1024);
//            $retour = explode(':', $donnees);
//
//            if(rtrim($retour[0]) === 'PING')
//            {
//                file_put_contents(__DIR__ . '/../../../testBot.txt', "> PING\r\n", FILE_APPEND);
//                file_put_contents(__DIR__ . '/../../../testBot.txt', "< PONG :$retour[1]\r\n", FILE_APPEND);
//                fputs($socket, 'PONG :' . $retour[1]);
//                $continuer = 0;
//            }
//            if($donnees)
//            {
//                echo $donnees;
//            }
//        }
//        fputs($socket, "JOIN #tenshi002\r\n");


        // Boucle principale du programme :
        while(1)
        {
            $donnees = fgets($socket, 1024); // On lit les données du serveur.
            if($donnees) // Si le serveur nous a envoyé quelque chose.
            {
                echo $donnees;
                $commande = explode(' ',$donnees);
                $message = explode(':',$donnees);

                $parserSocket = new Parser();
                $message = $parserSocket->parse($donnees);

                file_put_contents(__DIR__ . '/../../../testBot.txt', "steven> " . $message['params']['all'] ."\r\n", FILE_APPEND);
//                socket_close($socket);
//                die();
            }

            usleep(100); // On fait « dormir » le programme afin d'économiser l'utilisation du processeur.

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


}