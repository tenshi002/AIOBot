<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 01/08/17
 * Time: 12:55
 */

namespace lib;


use lib\Twitch\TwitchApi;

class TwitchInterpreter
{

    private $clientId;
    private $secret;
    private $jsonResponse;

    private $twitchAPI;

    private static $instance;

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new TwitchInterpreter();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->clientId = 'mkhfnaigie6r3v00odkhslexv31n28';
        $this->secret = 'csladm4tcrvh6v40zohtinqg6ho7te';
        $this->jsonResponse = array();

        $options = array(
            'client_id' => $this->clientId
        );

        $this->twitchAPI = new TwitchApi($options);
    }
    
}