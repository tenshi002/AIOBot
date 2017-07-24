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

    private static $instance = null;

    /**
     * @var Commande[]
     */
    private $commandes = array();

    private $logger;
    /**
     * @var string
     */

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general'));
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
        $this->logger->addDebug('traitement de la commande : ' . $nameCommande);
        //1 - traitement de la commande :
        if(class_exists('Duel'))
        {
            // alors c'est une classe avancée et donc personnalisée
            // init de la classe
            $nameClasse = ucfirst($nameCommande);
            $commandeAvancee = new $nameClasse;

            // execution de la commande
            $commandeAvancee->executeAction();

        }
        else
        {
            // sinon c'est une classe texte définie dans la db
        }


        $commande = $this->getCommande($nameCommande);
        if($commande !== false)
        {
            if(is_array($args) && !empty($args))
            {
                $commande->setArgs($args);
            }
            $this->getController($commande);
        }
    }

//    /**
//     * Retourne la liste des commandes disponible
//     * @return array
//     */
//    public function getListeCommands()
//    {
//        $commandesName = array();
//        foreach($this->commandes as $commande)
//        {
//            $commandesName[] = $commande->getCommentaire();
//        }
//        return $commandesName;
//    }

//    private function getController(Commande $commande)
//    {
//        $fichierControleur = $commande->getControleur() . 'Controleur.php';
//        // tentative de chargement des nouveaux modules gérant les espaces de nom
//        $classeControleur = 'controllers\\' . $commande->getControleur() . 'Controleur';
//        $pathController = __DIR__ . '/../controllers/' . $fichierControleur;
//        // chargement en prenant en compte l'autoloader
//        if(!class_exists($classeControleur))
//        {
//            // module sans espace de nom, donc non chargé
//            $classeControleur = $commande->getControleur() . 'Controleur';
//            //Vérification de l'existence du fichiers de controleurs cible
//            if(file_exists($pathController) && !class_exists($classeControleur))
//            {
//                require_once($pathController);
//            }
//        }
//        if(class_exists($classeControleur, false))
//        {
//            //Instanciation de la classe de controleurs
//            $controleur = new $classeControleur();
//
//            //Construction du nom réel de la méthode appellé pour l'action concernée
//            $methodeControleur = 'execute' . ucfirst($commande->getAction());
//            if(!method_exists($classeControleur, $methodeControleur))
//            {
//                //TODO on log l'exception
//                throw new Exception('La méthode ' . $methodeControleur . ' n\'existe pas dans le controleur ' . $classeControleur);
//            }
//
//            //Appel de la méthode qui construit la réponse
//            if(is_array($commande->getArgs()) && !empty($commande->getArgs()))
//            {
//                $controleur->$methodeControleur($commande->getArgs());
//            }
//            else
//            {
//                $controleur->$methodeControleur();
//            }
//        }
//    }

//    /**
//     *
//     */
//    private function loadCommandesConfig()
//    {
//        $xmlParser = new xmlParser($this->filepathCommandes);
//        $nodesRouteur = $xmlParser->getNodes(self::NODE_COMMANDE);
//        if($nodesRouteur !== false)
//        {
//            foreach($nodesRouteur as $node)
//            {
//                $route = new Commande();
//                foreach(Commande::getMappingAttributes() as $attributeClasse => $attributeXml)
//                {
//                    $setter = 'set' . ucfirst($attributeClasse);
//                    $route->$setter($node->getAttribute(utf8_encode($attributeXml)));
//                }
//                $this->commandes[] = $route;
//            }
//        }
//    }

    /**
     * @param string $commandeName
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
            $this->logger->addError('La commande : ' . $commandeName->getName() . ' n\'existe pas dans le fichier de commande');
        }
        return false;
    }
}