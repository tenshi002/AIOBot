<?php

namespace lib;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use lib\bot\Bot;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/Configuration.php';


/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 17/02/17
 * Time: 13:10
 */
class Application
{
    private $entityManager;

    private $routeur;

    /**
     * @var $configurateur Configuration
     */
    private $configurateur;

    static private $instance = null;

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

    private $logger;


    public function __construct()
    {
    }

    /**
     * Retourne une instance de cette classe.
     * Si la classe n'était pas instancié auparavant, une instance est créée
     *
     * @return Application
     */
    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    public function run()
    {
        //1 - récupérer l'url
        $actionId = $_GET['a'];
        $controllerId = $_GET['c'];

        //2- initialisation du fichier config
        $this->configurateur = new Configuration();
        $this->configurateur->initContainer();

        $bot = Bot::getInstance();
        $bot->writeMessage("coucou c'est moi, Elusionne");

        //3- on met en place le routeur
        $this->routeur = Routeurs::getInstance();
        $this->routeur->getRouteur($controllerId, $actionId);
    }

    public function getConfigurateur($name)
    {
        return $this->configurateur->get($name);
    }

    public function getLogger($pathLogger = null)
    {
        if(!is_null($pathLogger))
        {
            $path = __DIR__ . '/../../' . Application::getInstance()->getConfigurateur($pathLogger);
            $this->logger = new Logger('autres');
            $this->logger->pushHandler(new StreamHandler($path));
        }
        else
        {
            $pathGeneral = __DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general');
            $this->logger = new Logger('generale');
            $this->logger->pushHandler(new StreamHandler($pathGeneral));
        }
        return $this->logger;
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
}