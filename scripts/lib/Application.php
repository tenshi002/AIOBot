<?php

namespace lib;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


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

    private $logger;


    public function __construct()
    {
        //1- initialisation du fichier config
        $this->configurateur = new Configuration();
        $this->configurateur->initContainer();
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
        $this->routeur = Routeur::getInstance();
        $this->routeur->route();
    }

    public function getConfigurateur($name)
    {
        return $this->configurateur->get($name);
    }

    /**
     * @param null $pathLogger
     * @return Logger
     */
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
            $this->logger = new Logger('general');
            $this->logger->pushHandler(new StreamHandler($pathGeneral));
        }
        return $this->logger;
    }

    public function getApplicationBasePath()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if(is_null($this->entityManager))
        {
            $isDevMode = true;
            $config = Setup::createYAMLMetadataConfiguration(array(
                Application::getInstance()->getConfigurateur('doctrine.schema.path'),
                $isDevMode,
                Application::getInstance()->getConfigurateur('doctrine.proxies.path'),
            ));

            $dbParams = array(
                'driver'   => Application::getInstance()->getConfigurateur('doctrine.driver'),
                'user'     => Application::getInstance()->getConfigurateur('doctrine.user'),
                'password' => Application::getInstance()->getConfigurateur('doctrine.password'),
                'dbname'   => Application::getInstance()->getConfigurateur('doctrine.dbname'),
            );

            $this->entityManager = EntityManager::create($dbParams, $config);
        }
        return $this->entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}