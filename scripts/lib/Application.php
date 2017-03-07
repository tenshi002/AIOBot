<?php



require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/Configuration.php';
require_once __DIR__ . '/bot/bot.php';


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

    private $config;


    public function __construct()
    {
//        $this->config = Setup::createAnnotationMetadataConfiguration($this->getPaths(), $this->isIsDevMode());
//        $this->entityManager = EntityManager::create($this->getDbParams(), $this->getConfig());
//        $phergieConnection = new Connection();
//        $phergieConnection
//            ->setServerHostname('irc.chat.twitch.tv')
//            ->setServerPort(6667)
//            ->setPassword('oauth:l1y06nz7xuatiutwolccs6vc2w8doo')
//            ->setNickname('tenshi002')
//            ->setUsername('tenshi002');
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
        echo 'tati1 ';
        $bot = new bot();
        echo 'tata1 ';
        $bot->iniConnexion();
        echo 'tato1 ';

        //3- on met en place le routeur
//        $this->routeur = Routeur::getInstance();
//        $this->routeur->getRouteur($actionId, $controllerId);
    }

    public function getConfigurateur($name)
    {
        return $this->configurateur->get($name);
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