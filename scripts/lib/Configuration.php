<?php
use Zend\Config\Config;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 03/03/17
 * Time: 15:39
 */
class Configuration
{

    private $configuration;
    private $pathConfig = '../../configurations/configurateurs.txt';

    public function __construct()
    {

    }

    public function initContainer()
    {
        $this->configuration = new \Zend\Config\Reader\Ini();
        $this->configuration->fromFile($this->pathConfig);

    }

}