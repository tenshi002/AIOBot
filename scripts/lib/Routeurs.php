<?php

/**
 * Created by IntelliJ IDEA.
 * User: Tenshi002
 * Date: 16/02/2017
 * Time: 21:42
 */
class routeur
{

    private static $instance = null;

    public function __construct()
    {
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Routeur();
        }
        return self::$instance;
    }

    public function getRouteur($controller, $action)
    {
        $route = new Route($controller, $action);


    }

    private function getController(Route $route)
    {

        $fichierControleur = $controller . 'Controleur.php';
        // tentative de chargement des nouveaux modules g�rant les espaces de nom
        $classeControleur = 'controllers\\' . $controller . 'Controleur';
        $pathController = __DIR__ . '/../controllers/' . $fichierControleur;
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
            $controleur = new $classeControleur();

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

}