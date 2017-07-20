<?php

namespace lib;

use Exception;
use lib\HTTP\HTTPRequest;
use lib\HTTP\HTTPResponse;
use Monolog\Logger;

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 16/02/2017
 * Time: 21:42
 */
class Routeur
{
    const NODE_ROUTE = 'route';

    private static $instance = null;

    private $route;

    private $logger;

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general'));
        $HTTPRequest = HTTPRequest::getInstance();
        $this->route = new Route(
            $HTTPRequest->getGetParameter('module', Constantes::BASE_MODULE),
            $HTTPRequest->getGetParameter('controller', Constantes::BASE_CONTROLLER),
            $HTTPRequest->getGetParameter('action', Constantes::BASE_ACTION)
        );
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Routeur();
        }
        return self::$instance;
    }

    public function route()
    {
        $controllerClass = $this->route->getPHPClass();
        if(!class_exists($controllerClass))
        {
            if(!file_exists($this->route->getPHPPath()))
            {
                throw new Exception('Fichier controlleur introuvable');
            }
            require_once $this->route->getPHPPath();
        }

        $controller = new $controllerClass(
            $this->route->getModule(),
            $this->route->getController(),
            $this->route->getAction()
        );


        $method = 'execute' . ucfirst($this->route->getAction());
        if(!method_exists($controllerClass, $method))
        {
            throw new \Exception('Action introuvable !');
        }

        $controller->$method();

        HTTPResponse::getInstance(
            $this->route->getModule(),
            $this->route->getController(),
            $this->route->getAction()
        )->sendResponse();
    }

}