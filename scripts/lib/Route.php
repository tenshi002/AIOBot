<?php

namespace lib;

class Route
{
    const CONTROLLER_PARAM = 'controller';
    const ACTION_PARAM = 'action';

    private $module;
    private $controller;
    private $action;

    public function __construct($module, $controller, $action, $parameters = array())
    {
        if(!is_null($controller))
        {
            $this->setController($controller);
        }
        else
        {
            $this->setController('Index');
        }

        if(!is_null($action))
        {
            $this->setAction($action);
        }
        else
        {
            $this->setAction('Index');
        }

        $this->setModule($module);

        if(is_null($this->module))
        {
            $this->setModule($this->controller);
        }

    }

    /**
     * @return string
     */
    public function getPHPClass()
    {
        return 'controllers\\' . ucfirst($this->module) . '\\' . ucfirst($this->controller) . 'Controller';
    }

    /**
     * @return string
     */
    public function getPHPPath()
    {
        return '../controllers/' . ucfirst($this->module) . '/' . ucfirst($this->controller) . 'Controller.php';
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
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }


}