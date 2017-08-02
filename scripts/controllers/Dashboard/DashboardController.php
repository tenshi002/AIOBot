<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 02/08/17
 * Time: 16:14
 */

namespace controllers\Dashboard;

use lib\Application;
use lib\Controller;
use lib\Session;

class DashboardController extends Controller
{
    public function executeIndex()
    {
        $this->checkAuthOrRedirect();
        $session = Application::getInstance()->getSession();
//        $userTwitch = $this->getTwitchAPI()->getAuthenticatedUser($session->getAttribute(Session::TWITCH_ACCESS_TOKEN));
        $user = $session->getAttribute(Session::USER);
        $this->getHTTPResponse()->addTemplateVar('user', $user);
    }
}