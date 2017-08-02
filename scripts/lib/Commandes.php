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
use repositories\CommandeRepository;

class Commandes
{

    private static $instance = null;

    /**
     * @var Commande[]
     */
    private $commandes = array();
    private $entityManager;

    private $logger;
    /**
     * @var string
     */

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../' . Application::getInstance()->getConfigurateur('logger.general'));
        $this->entityManager = Application::getInstance()->getEntityManager();
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
        if(class_exists(ucfirst($nameCommande)))
        {
            // c'est une classe avancée et donc personnalisée
            // init de la classe
            $nameClasse = ucfirst($nameCommande);
            $commandeAvancee = new $nameClasse;

            // execution de la commande
            $commandeAvancee->executeAction($args);

        }
        else
        {
            // sinon c'est une classe texte définie dans la db
            /** @var $commandeRepository CommandeRepository*/
            $commandeRepository = $this->entityManager->getRepository('modeles\Commande');
            /** @var $commandeSimple \modeles\Commande*/
            $commandeSimple = $commandeRepository->findOneBy(array('nom', $nameCommande));

            $responses = $commandeSimple->getReponses();
            //TODO à vérifier
            return $responses[random_int(0, count($responses - 1))];

        }
    }
}