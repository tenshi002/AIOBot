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

    private $logger;

    public function __construct()
    {
        $applicationInstance = Application::getInstance();
        // fichier log modération
        $this->logger = $applicationInstance->getLogger('logger.moderation');
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
     * @param User $user
     * @param $message string texte du stream à vérifier
     * @return bool
     */
    public function antiLink(User $user, $message)
    {
        //TODO à verifier et completer !

        $regexp = '((http[s]?):\/\/)?([^:\/\s]+)\/([\w\-\.]+[^#?\s]+)?$';
        $regexpClipTwitch = '^(www\.|http[s]?)(:\/\/)?(www\.)?(clips\.twitch\.tv)(\/)?([\w\-\.]+[^#?\s]+)?$';

        if($user->getBotActiveClip() === 1)
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
     * @param User $streamer
     * @param $text
     * @return bool
     */
    public function wordsCensured(User $streamer, $text)
    {
        $wordsCensuredString = $streamer->getBotFiltreWords();
        $wordsCensured = explode(';', $wordsCensuredString);
        foreach($wordsCensured as $wordCensured)
        {
            $regexp = '(' . $wordCensured . ')';
            $result = preg_match('/' . $regexp . '/', $text);
            if($result === 1 && $result !== false)
            {
                return true;
            }
        }
        return false;
    }
}