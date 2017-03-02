<?php

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 02/03/17
 * Time: 14:27
 */
class defisGenerique
{
    /**
     * id du défis
     * @var
     */
    private $id;

    /**
     * Liste des defis disponible
     * @var array
     */
    private $defis = array();

    /**
     * nom du jeu sur laquel appliquer le défis
     * @var
     */
    private $game;

    /**
     * Chemin du fichier ou lire les défis
     * @var $filefilepath string
     */
    private $filefilepath;


    public function __construct($filepath)
    {
        $this->filefilepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getDefis()
    {
        return $this->defis;
    }

    /**
     * @param array $defis
     */
    public function setDefis($defis)
    {
        $this->defis = $defis;
    }

    /**
     * @return mixed
     */
    public function getFilefilepath()
    {
        return $this->filefilepath;
    }

    /**
     * @param mixed $filefilepath
     */
    public function setFilefilepath($filefilepath)
    {
        $this->filefilepath = $filefilepath;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }


}