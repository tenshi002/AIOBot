<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 02/08/17
 * Time: 14:52
 */

namespace controllers\Auth;

use lib\Application;
use lib\Auth\Auth;
use lib\Controller;
use lib\Cookie;
use lib\HTTP\HTTPResponse;
use lib\Twitch\Hydrator\UserHydrator;
use modeles\User;

class AuthController extends Controller
{
    use Auth;

    public function executeIndex()
    {
        $this->executeLogin();
    }

    public function executeLogin()
    {
        $code = $this->getHTTPRequest()->getGetParameter('code');
        $scope = $this->getHTTPRequest()->getGetParameter('scope');
        if(is_null($code) || is_null($scope))
        {
            $this->redirectIndex();
        }
        $accessCredentials = $this->getTwitchAPI()->getAccessCredentials($code);
        if(isset($accessCredentials['access_token']))
        {
            $userTwitch = $this->getTwitchAPI()->getAuthenticatedUser($accessCredentials['access_token']);
            $user = UserHydrator::getInstance()->getOrCreate($userTwitch);
            $user->setToken($accessCredentials['access_token']);
            $this->login($user, $code, $accessCredentials);
            Cookie::saveUserCookie($user);
            $this->redirect('Dashboard', 'Index');
        }
        else
        {

        }

    }

    /**
     * Permet au JS de savoir si la session PHP est toujour valide avant de lancer un appel AJAX au serveur
     */
    public function executeCheck()
    {
        $user = Application::getInstance()->getSession()->getUserFromSession();
        if($user instanceof User)
        {
            $session = true;
        }
        else
        {
            $session = false;
        }
        $data = array('session' => $session);
        $this->getHTTPResponse()->setContentType(HTTPResponse::CONTENT_TYPE_JSON);
        $this->getHTTPResponse()->setContent($data);
    }

    public function executeLogout()
    {
        $this->logout();
        $this->redirectIndex();
    }
}