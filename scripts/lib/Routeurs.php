<?php

namespace lib;

use modeles\Route\Route;
use Monolog\Logger;
use lib\xmlParser;

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 16/02/2017
 * Time: 21:42
 */
class Routeurs
{
    const NODE_ROUTE = 'route';

    private static $instance = null;

    /**
     * @var Route[]
     */
    private $routes = array();

    private $logger;

    /**
     * @var string
     */
    private $filepathRouteurs = __DIR__ . '/../../configurations/routeurs.xml';

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general'));
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Routeurs();
        }
        return self::$instance;
    }

    public function getRouteur($controllerId, $actionId)
    {
        // on match les id avec ceux du fichier xml
        $this->loadRouteurConfig();
        $route = $this->getRoute($controllerId, $actionId);
        $this->getController($route);
    }

    private function getController(Route $route)
    {
        $fichierControleur = $route->getControllerName() . 'Controleur.php';
        // tentative de chargement des nouveaux modules gérant les espaces de nom
        $classeControleur = 'controllers\\' . $route->getControllerName() . 'Controleur';
        $pathController = __DIR__ . '/../controllers/' . $fichierControleur;
        // chargement en prenant en compte l'autoloader
        if(!class_exists($classeControleur))
        {
            // module sans espace de nom, donc non chargé
            $classeControleur = $route->getControllerName() . 'Controleur';
            //Vérification de l'existence du fichiers de controleurs cible
            if(file_exists($pathController) && !class_exists($classeControleur))
            {
                require_once($pathController);
            }
        }
        if(class_exists($classeControleur, false))
        {
            //Instanciation de la classe de controleurs
            $controleur = new $classeControleur();

            //Construction du nom réel de la méthode appellé pour l'action concernée
            $methodeControleur = 'execute' . ucfirst($route->getActionName());
            if(!method_exists($classeControleur, $methodeControleur))
            {
                //TODO on log l'exception
                throw new Exception('La méthode ' . $methodeControleur . ' n\'existe pas dans le controleur ' . $classeControleur);
            }

            //Appel de la méthode qui construit la réponse
            $controleur->$methodeControleur();
        }
    }

    /**
     *
     */
    private function loadRouteurConfig()
    {
        $xmlParser = new xmlParser($this->filepathRouteurs);
        $nodesRouteur = $xmlParser->getNodes(self::NODE_ROUTE);
        if($nodesRouteur !== false)
        {
            foreach($nodesRouteur as $node)
            {
                $route = new Route();
                foreach(Route::getMappingAttributes() as $attributeClasse => $attributeXml)
                {
                    $setter = 'set' . ucfirst($attributeClasse);
                    $route->$setter($node->getAttribute(utf8_encode($attributeXml)));
                }
                $this->routes[] = $route;
            }
        }
    }

    /**
     * @param $controllerId
     * @param $actionId
     * @return bool|Route
     */
    private function getRoute($controllerId, $actionId)
    {
        if(is_array($this->routes) && !empty($this->routes))
        {
            foreach($this->routes as $route)
            {
                if($route->getControllerId() === $controllerId && $route->getActionId() === $actionId)
                {
                    return $route;
                }
            }

        }
        else
        {
            //TODO ajouter un logger
        }
        return false;
    }

}