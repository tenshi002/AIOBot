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
        //1 - r�cup�rer l'url
        $module = $_GET['module'];
        $action = $_GET['action'];
        $controller = $_GET['controller'];

        $this->getController($module, $controller, $action);
    }

    public function getController($module, $controller, $action)
    {

        $fichierControleur = $controller . 'Controleur.php';
        // tentative de chargement des nouveaux modules g�rant les espaces de nom
        $classeControleur = 'php\\' . $module . '\\' . $controller . 'Controleur';
        $pathController = __DIR__ . '/../php/' . $module . '/' . $fichierControleur;

        // chargement en prenant en compte l'autoloader
        if(!class_exists($classeControleur))
        {
            // module sans espace de nom, donc non charg�
            $classeControleur = $controller . 'Controleur';
            //V�rification de l'existence du fichiers de controleurs cible
            if(file_exists($pathController) && !class_exists($classeControleur))
            {
                require_once($pathController);
            }
        }
        if(class_exists($classeControleur, false))
        {
            //Instanciation de la classe de controleurs
            $controleur = new $classeControleur($module, $controller, $action);

            //Construction du nom r�el de la m�thode appell� pour l'action concern�e
            $methodeControleur = 'execute' . ucfirst($action);
            if(!method_exists($classeControleur, $methodeControleur))
            {
                throw new Exception('La m�thode ' . $methodeControleur . ' n\'existe pas dans le controleur ' . $classeControleur);
            }

            //Appel de la m�thode qui construit la r�ponse
            $controleur->$methodeControleur();
        }
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