<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 24/07/17
 * Time: 20:31
 */

namespace Commandes;


use lib\Application;
use lib\bot\Bot;
use modeles\Personne;
use repositories\PersonneRepository;

class Duel
{
    public function executeAction($args)
    {
        $elusionne = Bot::getInstance();

        //1 - on r�cup�re les pseudos

        $fighter1Name = $args[1];
        $fighter2Name = $args[2];
        $botName = Bot::getBotName();

        if($fighter1Name === $fighter2Name)
        {
            $elusionne->writeMessage('Tu ne peux pas te combattre toi-m�me petit coquinou (sauf si tu veux te faire hara-kiri ???');
        }
        elseif($fighter2Name === $botName)
        {
            $elusionne->writeMessage('/me met KO ' . $fighter1Name . ' en un coup !!!');
            $elusionne->writeMessage('Tu pensais me battre ? moi ? Tu en es tr�s loin Kappa ');
        }
        else
        {
            $personneRepository = new PersonneRepository();
            $fighter1 = $personneRepository->getPersonne($fighter1Name);
            $fighter2 = $personneRepository->getPersonne($fighter2Name);

            //2 - on initialise le combat
            $endOfFight = false;
            $results = array();
            $round = 0;
            if($elusionne)
            {
                //1 - on affiche le message du d�but de combat :
                $elusionne->writeMessage($fighter1Name . ' d�fi ' . $fighter2Name . ' dans un combat singulier � mort.');
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
                    $elusionne->writeMessage('Le gagnant du combat est : ' . $results['victoire'] . '. Le combat s\'est termin� en ' . $round . ' round.');
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