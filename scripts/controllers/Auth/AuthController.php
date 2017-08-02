<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 02/08/17
 * Time: 14:52
 */

namespace controllers\Auth;

use lib\Auth\Auth;
use lib\Controller;
use lib\Twitch\Hydrator\UserHydrator;

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
        $this->getTwitchAPI()->setRedirectUri('http://localhost/login');
        $accessCredentials = $this->getTwitchAPI()->getAccessCredentials($code);
        $userTwitch = $this->getTwitchAPI()->getAuthenticatedUser($accessCredentials['access_token']);
        $user = UserHydrator::getInstance()->getOrCreate($userTwitch);
        $this->login($user, $code, $accessCredentials);
        $this->redirect('Dashboard', 'Index');
    }
}