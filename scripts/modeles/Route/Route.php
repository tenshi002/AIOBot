<?php

namespace modeles\Route;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 03/03/17
 * Time: 11:03
 */
class Route
{
    private $controllerId;

    private $controllerName;

    private $actionId;

    private $actionName;

    private static $mappingAttributes = array(
        'controllerId' => 'controllerId',
        'controllerName' => 'controllerName',
        'actionId' => 'actionId',
        'actionName' => 'actionName'
    );

    public function __construct(){}

    /**
     * @return mixed
     */
    public function getControllerId()
    {
        return $this->controllerId;
    }

    /**
     * @param mixed $controllerId
     */
    public function setControllerId($controllerId)
    {
        $this->controllerId = $controllerId;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param mixed $controllerName
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return mixed
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * @param mixed $actionId
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param mixed $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @return array
     */
    public static function getMappingAttributes()
    {
        return self::$mappingAttributes;
    }


}