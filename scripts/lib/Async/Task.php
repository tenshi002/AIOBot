<?php

namespace lib\Async;

use Exception;
use InvalidArgumentException;
use LogicException;

abstract class Task
{
    private $statusFileName;
    private $status;

    const STATUS_READY = -2;
    const STATUS_PENDING = -1;
    const STATUS_STARTED = 0;
    const STATUS_COMPLETE = 100;
    const STATUS_FAILED = -3;

    /**
     * Construit une nouvelle tâche asynchrone
     *
     * @param string $statusFileName Le fichier qui permet de tracer l'avancement de la tâche
     * Ce fichier ne devrait jamais être manipulé directement, mais via getStatus() et setStatus();
     * Si null, un fichier temporaire est généré automatiquement.
     * @throws Exception
     */
    public function __construct($statusFileName = null)
    {
        $this->statusFileName = self::checkOrCreateFile($statusFileName);
        $this->status = self::STATUS_READY;
    }

    /**
     * Démarre la tâche. Le rôle de cette méthode est seulement de maintenire
     * la cohérence du statut (démarré, en cours d'exécution, terminé).
     * La fonction self::execute() doit être implémentée, c'est elle qui fera
     * le vrai travail.
     * La tâche asynchrone doit confirmer son démarrage avec setStatus(self::STATUS_STARTED)
     *
     * @return mixed La valeur de retour de self::execute()
     * @throws LogicException
     */
    public final function start()
    {
        if($this->isStarted())
        {
            throw new LogicException('Tâche déjà démarrée');
        }
        $this->setStatus(self::STATUS_PENDING);
        $returnValue = $this->spawn();
        if($returnValue === false)
        {
            $this->setStatus(self::STATUS_FAILED);
        }
        return $returnValue;
    }

    /**
     * Met à jour le Statut de la tâche.
     *
     * @param int $status
     * @throws LogicException
     * @throws InvalidArgumentException
     * @throws Exception
     */
    protected final function setStatus($status)
    {
        if($status === self::STATUS_PENDING && $this->status !== self::STATUS_READY)
        {
            throw new LogicException('La tâche n\'est pas encore démarrée');
        }
        if($status === self::STATUS_STARTED && ($this->status === self::STATUS_READY || $this->status === self::STATUS_FAILED))
        {
            throw new LogicException('La tâche n\'a pas été démarrée de manière asynchrone, ou bien elle a échoué');
        }
        if(!is_numeric($status) || $status < self::STATUS_FAILED || $status > self::STATUS_COMPLETE)
        {
            throw new InvalidArgumentException('STATUS_COMPLETE ou STATUS_FAILED ou Entier entre 0 et 100 attendu');
        }

        if(!is_writable($this->statusFileName) || file_put_contents($this->statusFileName, $status) === false)
        {
            throw new Exception('Status inaccessible. La tâche a peut-être été détruite par ailleurs.');
        }
        $this->status = $status;
    }

    public function getStatus()
    {
        if($this->isRunning())
        {
            $this->status = file_get_contents($this->statusFileName);
        }
        if($this->status === false)
        {
            throw new Exception('Status illisible. La tâche a peut-être été détruite par ailleurs.');
        }
        return $this->status;
    }

    public final function isStarted()
    {
        return $this->status !== self::STATUS_READY;
    }

    public final function isRunning()
    {
        return
            $this->status >= self::STATUS_PENDING &&
            $this->status <= self::STATUS_COMPLETE;
    }

    /**
     * Le dernier éteint la lumière en partant, s'il vous plaît
     * Supprime les fichiers temporaires.
     * Rend inutilisable toute référence à la task.
     */
    public function cleanup()
    {
        unlink($this->statusFileName);
    }

    /**
     * Doit implémenter les opérations permettant de démarrer une tâche asynchrone.
     *
     * @return mixed False si l'opération n'a pas pu être lancée. Autre chose sinon.
     */
    protected abstract function spawn();

    protected final static function checkOrCreateFile($filename = null)
    {
        if(is_null($filename))
        {
            $filename = tempnam(sys_get_temp_dir(), 'task_');
            if($filename === false)
            {
                throw new Exception();
            }
        }
        elseif(!file_exists($filename))
        {
            if(!touch($filename))
            {
                throw new Exception();
            }
        }
        elseif(!is_writable($filename))
        {
            throw new Exception();
        }
        return $filename;
    }

}
