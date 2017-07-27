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

    public function antiLink($message)
    {
        $regexp = '^((http[s]?):\/\/)?([^:\/\s]+)\/([\w\-\.]+[^#?\s]+)?$';
        $regexpClipTwitch = '^(www\.|http[s]?)(:\/\/)?(www\.)?(clips\.twitch\.tv)(\/)?([\w\-\.]+[^#?\s]+)?$';
        if(preg_match('/' . $regexp . '/', $message))
        {

        }

        return false;
    }

}