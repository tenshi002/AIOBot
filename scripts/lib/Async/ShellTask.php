<?php

namespace lib\Async;

use Exception;

class ShellTask extends Task
{
    protected $command;
    protected $arguments;
    private $pid;

    /**
     * Construit une nouvelle tâche asynchrone destinée à exécuter une commande Shell
     * @param string $command Commande shell à exécuter. Sera exécutée par exec().
     * @param string $statusFileName Le fichier attendu pour logguer le résultat.
     * Ce nom de fichier sera passé en premier paramètre à la commande
     * @throws Exception
     */
    public function __construct($command, array $arguments = array(), $statusFileName = null)
    {
        parent::__construct($statusFileName);
        if (empty($command))
        {
            throw new Exception();
        }
        $this->command = $command;
        $this->arguments = $arguments;
        array_unshift($this->arguments, realpath($statusFileName));
    }

    public final function getPID()
    {
        return $this->pid;
    }

    public final function getStatus()
    {
        $processNotFound = null;
        system('kill -0 ' . $this->pid, $processNotFound);
        $status = parent::getStatus();
        if($processNotFound && $status >= self::STATUS_STARTED && $status < self::STATUS_COMPLETE)
        {
            $status = self::STATUS_FAILED;
            $this->setStatus(self::STATUS_FAILED);
        }

        return $status;
    }

    /**
     * Exécute une commande Shell en arrière-plan dans un nouveau processus
     * @return int le pid du nouveau processus
     */
    protected function spawn()
    {
        $this->pid = ExecUtils::execSafe($this->command, $this->arguments, true);
        return $this->pid;
    }
}
?>
