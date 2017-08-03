<?php

namespace controllers\Index;

use lib\Application;
use lib\Auth\Auth;
use lib\Controller;
use lib\Cookie;
use lib\Session;
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
        
    }
}