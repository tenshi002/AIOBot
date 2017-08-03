<?php

namespace controllers\Index;

use lib\Application;
use lib\Auth\Auth;
use lib\Controller;
use lib\Cookie;
use lib\Session;
use lib\Twitch\Hydrator\UserHydrator;
use modeles\User;

class IndexController extends Controller
{
    use Auth;

    public function executeIndex()
    {
        // Si la session php est active on va sur le dashboard
        $session = Application::getInstance()->getSession();
        if($session->getAttribute(Session::LOGGED_IN) === true)
        {
            $this->redirect('Dashboard', 'Index');
        }
        // Si le cookie est ok on login
        $user = Cookie::loadUserFromCookie();
        if($user instanceof User)
        {
            $this->loginFromCookie($user);
            $this->redirect('Dashboard', 'Index');
        }
    }

    public function executeIndexProfile()
    {
        $actualUser = Application::getInstance()->getTwitchChannel();
        $channelIdentifier = $this->getTwitchAPI()->getUserByUsername($actualUser);
        $user = UserHydrator::getInstance()->getOrCreate($channelIdentifier['users'][0]);
        $this->getHTTPResponse()->addTemplateVars(array(
            'user' => $user
        ));
    }
}