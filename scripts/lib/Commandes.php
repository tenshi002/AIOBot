<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 30/03/17
 * Time: 15:01
 */

namespace lib;


use Exception;
use modeles\Commande\Commande;
use Monolog\Logger;

class Commandes
{
    const NODE_COMMANDE = 'commande';

    private static $instance = null;

    /**
     * @var Commande[]
     */
    private $commandes = array();

    private $logger;
    /**
     * @var string
     */
    private $filepathCommandes = __DIR__ . '/../../configurations/commandes.xml';

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general'));
        // on match les id avec ceux du fichier xml
        $this->loadCommandesConfig();
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Commandes();
        }
        return self::$instance;
    }

    public function getCommandes($nameCommande, $args = array())
    {

        $commande = $this->getCommande($nameCommande);
        if(is_array($args) && !empty($args))
        {
            $commande->setArgs($args);
        }
        $this->getController($commande);
    }

    /**
     * Retourne la liste des commandes disponible
     * @return array
     */
    public function getListeCommands()
    {
        $commandesName = array();
        foreach($this->commandes as $commande)
        {
            $commandesName[] = $commande->getName();
        }
        return $commandesName;
    }

    private function getController(Commande $commande)
    {
        $fichierControleur = $commande->getControleur() . 'Controleur.php';
        // tentative de chargement des nouveaux modules g�rant les espaces de nom
        $classeControleur = 'controllers\\' . $commande->getControleur() . 'Controleur';
        $pathController = __DIR__ . '/../controllers/' . $fichierControleur;
        // chargement en prenant en compte l'autoloader
        if(!class_exists($classeControleur))
        {
            // module sans espace de nom, donc non charg�
            $classeControleur = $commande->getControleur() . 'Controleur';
            //V�rification de l'existence du fichiers de controleurs cible
            if(file_exists($pathController) && !class_exists($classeControleur))
            {
                require_once($pathController);
            }
        }
        if(class_exists($classeControleur, false))
        {
            //Instanciation de la classe de controleurs
            $controleur = new $classeControleur();

            //Construction du nom r�el de la m�thode appell� pour l'action concern�e
            $methodeControleur = 'execute' . ucfirst($commande->getAction());
            if(!method_exists($classeControleur, $methodeControleur))
            {
                //TODO on log l'exception
                throw new Exception('La m�thode ' . $methodeControleur . ' n\'existe pas dans le controleur ' . $classeControleur);
            }

            //Appel de la m�thode qui construit la r�ponse
            if(is_array($commande->getArgs()) && !empty($commande->getArgs()))
            {
                $controleur->$methodeControleur($commande->getArgs());
            }
            else
            {
                $controleur->$methodeControleur();
            }
        }
    }

    /**
     *
     */
    private function loadCommandesConfig()
    {
        $xmlParser = new xmlParser($this->filepathCommandes);
        $nodesRouteur = $xmlParser->getNodes(self::NODE_COMMANDE);
        if($nodesRouteur !== false)
        {
            foreach($nodesRouteur as $node)
            {
                $route = new Commande();
                foreach(Commande::getMappingAttributes() as $attributeClasse => $attributeXml)
                {
                    $setter = 'set' . ucfirst($attributeClasse);
                    $route->$setter($node->getAttribute(utf8_encode($attributeXml)));
                }
                $this->commandes[] = $route;
            }
        }
    }

    /**
     * @param Commande $commandeName
     * @return bool|Commande
     */
    private function getCommande($commandeName)
    {
        if(is_array($this->commandes) && !empty($this->commandes))
        {
            foreach($this->commandes as $commande)
            {
                if($commande->getName() === $commandeName)
                {
                    return $commande;
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