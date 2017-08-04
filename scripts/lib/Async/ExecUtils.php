<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 04/08/17
 * Time: 11:05
 */

namespace lib\Async;
use lib\Application;


/**
 * Classe utilitaire regroupant les parametrages de la commande exec()
 *
 */
class ExecUtils
{
    const DEFAULT_NICE_LEVEL = 10;

    /**
     * Exécute une commande avec une priorité donnée. Attention, la commande passée n'est pas contrôlée,
     * l'appelant est responsable de l'échappement des caractères spéciaux de sa commande.
     *
     * @param $command
     * @param $level
     * @return string
     */
    static public function execLowPriorityNoEscaping($command, $level = null)
    {
        $default = '';
        if(is_null($level))
        {
            $level = self::DEFAULT_NICE_LEVEL;
            $default = ' default';
        }
        $logger = Application::getInstance()->getLogger();
        $logger->info('Executing with' . $default . ' low priority (nice -n ' . $level . ') : ' . $command);
        return exec('nice -n ' . $level . ' ' . $command);
    }

    /**
     * Exécute une commande avec une priorité donnée.
     * L'échappement de la commande et de ses paramètres est prise en charge par la fonction.
     * L'encodage doit correspondre à celui par défaut du shell.
     * @param string $command
     * @param string[] $arguments
     * @param boolean $background Détermine si la commande est lancée en arrière-plan
     * @param int $niceLevel Si null, alors la priorité par défaut est appliquée
     * (celle de la config Zend si définie, ou à défaut, self::DEFAULT_NICE_LEVEL)
     * @return string|int la dernière ligne de la sortie de la commande, ou le pid si le processus est lancé en arrière-plan
     */
    static public function execSafe($command, array $arguments, $background = false, $niceLevel = null)
    {
        $default = '';
        if(is_null($niceLevel))
        {
            $niceLevel = self::DEFAULT_NICE_LEVEL;
            $default = ' default';
        }

        $commandLine = escapeshellcmd($command);
        if (is_array($arguments))
        {
            foreach($arguments as $arg)
            {
                $commandLine .= ' ' . escapeshellarg($arg);
            }
        }

        //logs
        $execLog = '';
        $logLevel = getenv('NIVEAU_LOG');
        if($logLevel != '')
        {
            $execLog = 'NIVEAU_LOG='.$logLevel;
        }

        $logger = Application::getInstance()->getLogger();
        $logger->info('Executing with' . $default . ' priority ('.$execLog. ' nice -n ' . $niceLevel . ') : ' . $commandLine);


        if ($background)
        {
            $r = exec("$execLog nohup nice -n $niceLevel $commandLine >/tmp/execSafe.out 2>&1 & echo $!");
            // TODO : vérifier ici que le processus est bien lancé (comment ?)
            return (int) $r;
        }
        else
        {
            return exec("$execLog nice -n $niceLevel $commandLine");
        }
    }

}
