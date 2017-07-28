<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 27/07/17
 * Time: 15:21
 */

namespace lib;


class Moderations
{

    private $logger;

    public function __construct()
    {
        // fichier log modération
        $this->logger = Application::getInstance()->getLogger('logger.moderation');

        //TODO récupérer la conf web du bot via un autre fichier ini ?
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
        // 1 - on verifie si le texte contient un lien clip twitch
        $matchClip = preg_match('/' . $regexpClipTwitch . '/', $message);
        if($matchClip === 1 && $matchClip !== null)
        {
            return false;
        }

        // 2 - le texte ne contient pas la mention clip, on test s'il contient un lien
        $matchLink = preg_match($regexp, $message);
        if($matchLink === 1 && $matchLink !== null)
        {
            return true;
        }

        return false;
    }

    public function antiSpam($message)
    {
        // 1 - on traite le cas des majuscules :
        $messagesArray = explode(' ', $message);
        $fullStringUpper = true;
        foreach($messagesArray as $word)
        {
            if(ctype_upper($word))
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

}