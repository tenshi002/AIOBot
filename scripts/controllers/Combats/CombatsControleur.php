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

class CombatsControleur
{

    private $filepathTimer = __DIR__ . '/../../timers/combatTimer.txt';
    private $fileName = '';

    public function executeCombatSolo($args)
    {
        // Déporté dans CommandesAvancee/Commandes/Duel.php
    }
}