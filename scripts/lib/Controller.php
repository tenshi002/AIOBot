<?php

namespace lib;

use lib\bot\Bot;
use lib\HTTP\HTTPRequest;
use lib\HTTP\HTTPResponse;
use lib\Twitch\TwitchApi;

/**
 * Classe permettant de rediriger vers les différents controleurs
 */
abstract class Controller
{

    protected $module;
    protected $controller;
    protected $action;

    /**
     * @var HTTPRequest
     */
    protected $HTTPRequest;
    /**
     * @var HTTPResponse
     */
    protected $HTTPResponse;

    /**
     * @var TwitchApi
     */
    protected $twitchAPI;

    /**
     * @var Bot
     */
    protected $bot;

    public function executeIndex()
    {
        $this->getHTTPResponse()->setContentType(HTTPResponse::CONTENT_TYPE_JSON);
        $this->getHTTPResponse()->setContent(array());
    }

    public function __construct($module, $controller, $action)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;

        $this->HTTPRequest = HTTPRequest::getInstance();
        $this->HTTPResponse = HTTPResponse::getInstance($this->module, $this->controller, $this->action);
        //        $this->bot = Bot::getInstance();
    }

    protected function checkAuthOrRedirect()
    {
        if(!$this->isAuth())
        {
            $this->redirectIndex();
        }
    }

    protected function isAuth()
    {
        if(Application::getInstance()->getSession()->getAttribute(Session::LOGGED_IN) === true)
        {
            return true;
        }
        return false;
    }

    /**
     * Redirige vers une autre page
     *
     * @param string $module Le module vers lequel rediriger l'utilisateur
     * @param string $action L'action à executer
     * @param array $httpGetVars Tableau de variables supplémentaires à passer en GET
     */
    public function redirect($module, $action, array $httpGetVars = array(), $controller = null)
    {
        $url = $this->generateUrl($module, $action, $httpGetVars, $controller);
        $this->redirectUrl($url);
    }

    /**
     * Redirige vers une autre page
     *
     * @param $url
     */
    public function redirectUrl($url)
    {
        header('Location: ' . $url);
        exit(0);
    }

    public function redirectIndex()
    {
        $this->redirect(Constantes::BASE_MODULE, Constantes::BASE_ACTION);
    }

    public function generateUrl($module, $action, array $httpGetVars = array(), $controller = null)
    {
        $queryData = array_merge(array(
            'module' => $module,
            'action' => $action
        ), $httpGetVars);
        if(isset($controller))
        {
            $queryData = array_merge(
                $queryData, array('controller' => $controller)
            );
        }
        $urlGetVars = http_build_query($queryData);
        return 'index.php?' . $urlGetVars;
    }

    /****************************************
     *
     *          GETTERS - SETTERS
     *
     ***************************************/

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return HTTPRequest
     */
    public function getHTTPRequest()
    {
        return $this->HTTPRequest;
    }

    /**
     * @param HTTPRequest $HTTPRequest
     */
    public function setHTTPRequest($HTTPRequest)
    {
        $this->HTTPRequest = $HTTPRequest;
    }

    /**
     * @return HTTPResponse
     */
    public function getHTTPResponse()
    {
        return $this->HTTPResponse;
    }

    /**
     * @param HTTPResponse $HTTPResponse
     */
    public function setHTTPResponse($HTTPResponse)
    {
        $this->HTTPResponse = $HTTPResponse;
    }

    /**
     * @return Bot
     */
    public function getBot()
    {
        return $this->bot;
    }

    /**
     * @param Bot $bot
     */
    public function setBot($bot)
    {
        $this->bot = $bot;
    }

    /**
     * @return TwitchApi
     */
    public function getTwitchAPI()
    {
        if(is_null($this->twitchAPI))
        {
            $this->twitchAPI = TwitchApi::getInstance();
        }
        return $this->twitchAPI;
    }

}