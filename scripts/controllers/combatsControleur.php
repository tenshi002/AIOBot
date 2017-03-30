<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 13/03/17
 * Time: 09:19
 */

namespace controllers;


use lib\Application;
use lib\bot\Bot;
use modeles\Combattant\Combattant;
use Monolog\Logger;

class combatsControleur
{

    private $filepathTimer = __DIR__ . '/../../timers/combatTimer.txt';
    private $fileName = '';

    public function executeCombatSolo($args)
    {
        $logger = Application::getInstance()->getLogger();
        $timestampActuel = time();
        //TODO récupérer l'heure de la commande
        //TODO vérifier si la commande n'a pas déjà était executé avant si le fichier n'existe pas on le crée
//        if(file_exists($this->filepathTimer))
//        {
//            //on vérifie récupère le temps timestamp enregistré
//            $timestampLimit = file_get_contents($this->filepathTimer);
//            if(isset($timestampLimit))
//            {
//                $diffTimer = $timestampLimit - $timestampActuel;
//                if($diffTimer > 0)
//                {
//                    $logger->addInfo('Commande Combat Solo execute recemment.');
//                    return;
//                }
//                else
//                {
//                    //on set le nouveau timestamp
//                    //$newTimestamp = $timestampActuel +
//                    //file_put_contents($this->filepathTimer, $newTimestamp);
//                }
//            }
//
//        }
//        else
//        {
//            //on crée le fichier
//            //on set le nouveau timestamp
//            //$newTimestamp = $timestampActuel +
//            //file_put_contents($this->filepathTimer, $newTimestamp);
//        }


//        $timer = Application::getInstance()->getConfigurateur('timer.commandes');
        $elusionne = Bot::getInstance();

        //1 - on récupère les pseudos

        $fighter1Name = $args[1];
        $fighter2Name = $args[2];

        if($fighter1Name === $fighter2Name)
        {
            $elusionne->writeMessage('Tu ne peux pas te combattre toi-même petit coquinou (sauf si tu veux te faire hara-kiri ???');
        }
        else
        {
            $fighter1 = new Combattant($fighter1Name);
            $fighter2 = new Combattant($fighter2Name);


            //2 - on initialise le combat
            $endOfFight = false;
            $results = array();
            $round = 0;
            if($elusionne)
            {
                //1 - on affiche le message du début de combat :
                $elusionne->writeMessage($fighter1Name . ' défi ' . $fighter2Name . ' dans un combat singulier à mort.');
                while(!$endOfFight)
                {
                    $round++;
                    if($fighter1->getInitiative() > $fighter2->getInitiative())
                    {
                        $results = $this->fight($fighter1, $fighter2);
                    }
                    else
                    {
                        $results = $this->fight($fighter2, $fighter1);
                    }
                    $endOfFight = $results['endOfFight'];
                }
                if($endOfFight)
                {
                    $elusionne->writeMessage('Le gagnant du combat est : ' . $results['victoire'] . '. Le combat s\'est terminé en ' . $round . ' round.');
                }
            }
        }

    }

    private function fight(Combattant $fighter1, Combattant $fighter2)
    {
        $result = array();
        $fighter2->setLife($fighter2->getLife() - random_int(1, 5));
        if($fighter2->getLife() <= 0)
        {
            $result['endOfFight'] = true;
            $result['victoire'] = $fighter1->getName();
            return $result;
        }

        $fighter1->setLife($fighter1->getLife() - random_int(1, 5));
        if($fighter1->getLife() <= 0)
        {
            $result['endOfFight'] = true;
            $result['victoire'] = $fighter2->getName();
            return $result;
        }
        return $result['endOfFight'] = false;
    }
}