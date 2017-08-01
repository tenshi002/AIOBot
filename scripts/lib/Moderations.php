<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 27/07/17
 * Time: 15:21
 */

namespace lib;


use modeles\User;

class Moderations
{
    static private $instance = null;
    static private $statusAntiLink;
    static private $statusAuthorizeClipTwitch;
    static private $statusAntiSpamUppercase;
    static private $statusAntiSpamEmote;

    private $logger;
    private $user;

    public function __construct()
    {
        $applicationInstance = Application::getInstance();
        // fichier log modération
        $this->logger = $applicationInstance->getLogger('logger.moderation');
        $this->user = new User();

        //TODO récupérer la conf web à partir du modele User ?
//        self::$statusAntiLink = $applicationInstance->getConfigurateur('moderation.antiLink');
//        self::$statusAuthorizeClipTwitch = $applicationInstance->getConfigurateur('moderation.authorizeClipTwitch');
//        self::$statusAntiSpamUppercase = $applicationInstance->getConfigurateur('moderation.antiSpamUppercase');
//        self::$statusAntiSpamEmote = $applicationInstance->getConfigurateur('moderation.antiSpamEmote');
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Moderations();
        }
        return self::$instance;
    }

    /**
     * @param $message string texte du stream à vérifier
     * @return bool
     */
    public function antiLink($message)
    {
        //TODO à verifier et completer !

        $regexp = '((http[s]?):\/\/)?([^:\/\s]+)\/([\w\-\.]+[^#?\s]+)?$';
        $regexpClipTwitch = '^(www\.|http[s]?)(:\/\/)?(www\.)?(clips\.twitch\.tv)(\/)?([\w\-\.]+[^#?\s]+)?$';

        if(self::getStatusAuthorizeClipTwitch() === 1)
        {
            // 1 - on verifie si le texte contient un lien clip twitch
            $matchClip = preg_match('/' . $regexpClipTwitch . '/', $message);
            //On match un résultat donc le lien est autorisé
            if($matchClip === 1 && $matchClip !== false)
            {
                return false;
            }
        }

        // 2 - le texte ne contient pas la mention clip, on test s'il contient un lien
        $matchLink = preg_match($regexp, $message);
        if($matchLink === 1 && $matchLink !== false)
        {
            return true;
        }

        // 3 - pas de lien on ne fait rien
        return false;
    }

    /**
     * On supprime les caractères numériques et on vérifie si la chaine est en majuscule ou non
     * @param $message
     * @return bool
     */
    public function antiSpam($message)
    {
        // 1 - on traite le cas des majuscules :
        $messagesArray = explode(' ', trim($message));
        $fullStringUpper = true;
        foreach($messagesArray as $word)
        {
            $words = preg_replace('/\d+/u', '', $word );
            if(ctype_upper($words))
            {
                continue;
            }
            else
            {
                $fullStringUpper = false;
                break;
            }
        }

        if($fullStringUpper)
        {
            return true;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public static function getStatusAntiLink()
    {
        return self::$statusAntiLink;
    }

    /**
     * @return bool|string
     */
    public static function getStatusAuthorizeClipTwitch()
    {
        return self::$statusAuthorizeClipTwitch;
    }

    /**
     * @return bool|string
     */
    public static function getStatusAntiSpamUppercase()
    {
        return self::$statusAntiSpamUppercase;
    }

    /**
     * @return bool|string
     */
    public static function getStatusAntiSpamEmote()
    {
        return self::$statusAntiSpamEmote;
    }

}