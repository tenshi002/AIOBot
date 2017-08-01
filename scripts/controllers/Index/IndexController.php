<?php

namespace controllers\Index;

use lib\Controller;
use lib\Twitch\Hydrator\UserHydrator;
use lib\Twitch\TwitchApi;

class IndexController extends Controller
{
    public function executeIndex()
    {
        $this->getHTTPResponse()->addTemplateVar('title', 'LOLPAGE');
        $channelIdentifier = $this->getTwitchAPI()->getUserByUsername('tenshi002');
        $hydrator = new UserHydrator();
        $user = $hydrator->getOrCreate($channelIdentifier['users'][0]);
        $json = TwitchApi::getInstance()->getChannelFollowers('89199435');
        $this->getHTTPResponse()->addTemplateVar('json', $json);
    }
}