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

    private $module;
    private $controller;
    private $action;

    /**
     * @var HTTPRequest
     */
    private $HTTPRequest;
    /**
     * @var HTTPResponse
     */
    private $HTTPResponse;

    /**
     * @var Bot
     */
    private $bot;

    public function __construct($module, $controller, $action)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;

        $this->HTTPRequest = HTTPRequest::getInstance();
        $this->HTTPResponse = HTTPResponse::getInstance($this->module, $this->controller, $this->action);
        $this->bot = Bot::getInstance();
    }
}