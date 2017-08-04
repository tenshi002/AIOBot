<?php

namespace lib\Async;

use ReflectionClass;

abstract class PhpTask extends ShellTask
{
    private $contextFileName;

    public function __construct($statusFileName = null)
    {
        parent::__construct('/usr/local/php/bin/php' , array(), $statusFileName); // PHP_BINARY n'existe qu'à partir de 5.4

        $reflection = new ReflectionClass(get_class($this));
        $runnableFileName = realpath($reflection->getFileName());

        $this->contextFileName = $this->checkOrCreateFile();

        $this->arguments = array(
            realpath(__DIR__ . DIRECTORY_SEPARATOR . 'phprunner.php'),
            $runnableFileName,
            $this->contextFileName,
            APPLICATION_PATH
        );
        // pas besoin de repasser le $statusFileName en paramètre, l'information est dans Task::$statusFileName
    }

    public function cleanup()
    {
        unlink($this->contextFileName);
        parent::cleanup();
    }
    /**
     * Doit implémenter la fonction exécutée par le processus asynchrone
     */
    public abstract function run();

    public final function confirmStartup()
    {
        $this->setStatus(self::STATUS_STARTED);
    }

    /**
     * Démarre un interpéteur PHP via un appel Shell en arrière-plan dans un nouveau processus.
     * @return int Le pid du nouveau processus
     */
    protected final function spawn()
    {
        file_put_contents($this->contextFileName, serialize($this));
        return parent::spawn();
    }

}
?>
