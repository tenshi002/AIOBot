<?php

namespace controllers\Index;

use lib\Application;
use lib\Controller;
use lib\Twitch\Hydrator\UserHydrator;

class IndexController extends Controller
{
    public function executeIndex()
    {
        $this->getHTTPResponse()->addTemplateVar('title', 'LOLPAGE');
        $actualUser = Application::getInstance()->getTwitchChannel();
        $channelIdentifier = $this->getTwitchAPI()->getUserByUsername($actualUser);
        $hydrator = new UserHydrator();
        $user = $hydrator->getOrCreate($channelIdentifier['users'][0]);
        $this->getHTTPResponse()->addTemplateVars(array(
            'user' => $user
        ));
    }
}