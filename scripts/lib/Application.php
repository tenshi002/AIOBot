<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\orm\EntityManager;

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 17/02/17
 * Time: 13:10
 */
class Application
{
    private $entityManager;

    /**
     * chemin vers le fichier entity
     *
     * @var $path string
     */
    private $paths = array('');
    private $isDevMode = false;

    private $dbParams = array(
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '',
        'dbname' => '',
    );

    private $config;


    public function __construct()
    {
        $this->config = Setup::createAnnotationMetadataConfiguration($this->getPaths(), $this->isIsDevMode());
        $this->entityManager = EntityManager::create($this->getDbParams(), $this->getConfig());
    }

    public function run()
    {
        $this->getController();
    }

    public function getController()
    {
        $routeur = new Routeur();
        $routeur->route();
    }

    /**
     * @return mixed
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param string $paths
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;
    }

    /**
     * @return boolean
     */
    public function isIsDevMode()
    {
        return $this->isDevMode;
    }

    /**
     * @param boolean $isDevMode
     */
    public function setIsDevMode($isDevMode)
    {
        $this->isDevMode = $isDevMode;
    }

    /**
     * @return array
     */
    public function getDbParams()
    {
        return $this->dbParams;
    }

    /**
     * @param array $dbParams
     */
    public function setDbParams($dbParams)
    {
        $this->dbParams = $dbParams;
    }

    /**
     * @return \Doctrine\ORM\Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Doctrine\ORM\Configuration $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}