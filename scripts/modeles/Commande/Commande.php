<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 30/03/17
 * Time: 15:08
 */

namespace modeles\Commande;


class Commande
{
    private $name;

    private $controleur;

    private $action;

    private $commentaire;

    /**
     * Argument à passer en paramï¿½tre de la fonction
     * @var array
     */
    private $args;

    private static $mappingAttributes = array(
        'name' => 'name',
        'controleur' => 'controleur',
        'action' => 'action',
        'commentaire' => 'commentaire'
    );

    public function __construct(){}

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getControleur()
    {
        return $this->controleur;
    }

    /**
     * @param mixed $controleur
     */
    public function setControleur($controleur)
    {
        $this->controleur = $controleur;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param mixed $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @param array $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }

    /**
     * @return array
     */
    public static function getMappingAttributes()
    {
        return self::$mappingAttributes;
    }


}