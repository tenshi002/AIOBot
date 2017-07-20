<?php

namespace lib;

use lib\bot\Bot;
use lib\HTTP\HTTPRequest;
use lib\HTTP\HTTPResponse;

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
     * @var Bot
     */
    protected $bot;

    public function __construct($module, $controller, $action)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;

        $this->HTTPRequest = HTTPRequest::getInstance();
        $this->HTTPResponse = HTTPResponse::getInstance($this->module, $this->controller, $this->action);
        //        $this->bot = Bot::getInstance();
    }

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
}