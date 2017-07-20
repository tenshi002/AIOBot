<?php

namespace lib\HTTP;
use Serializable;

/**
 * Classe basique pour la gestion de paramètres des requetes
 */
class ParameterHolder implements Serializable
{

    /**
     * Les paramètres de cette requête
     *
     * @var array un tableau de paramètres
     */
    protected $parameters = array();

    /**
     * Le constructeur de ParameterHolder.
     */
    public function __construct()
    {

    }

    /**
     * Efface tous les paramètres associés à la requete.
     */
    public function clear()
    {
        $this->parameters = array();
    }

    /**
     * Recupère un paramètre.
     *
     * @param  string $name     Le nom d'un paramètre
     * @param  mixed  $default  La valeur par défaut du paramètre
     *
     * @return mixed La valeur d'un paramètre s'il existe, null sinon
     */
    public function & get($name, $default = null)
    {
        if(array_key_exists($name, $this->parameters))
        {
            $value = & $this->parameters[$name];
        }
        else
        {
            $value = $default;
        }

        return $value;
    }

    /**
     * Retourne un tableau de nom de paramètres.
     *
     * @return array Un tbaleau indeé de noms de paramètres
     */
    public function getNames()
    {
        return array_keys($this->parameters);
    }

    /**
     * Recupère tous les paramètres dans un tableau.
     *
     * @return array Un tableau associatif de paramètres
     */
    public function & getAll()
    {
        return $this->parameters;
    }

    /**
     * Indique si un paramètre existe ou non.
     *
     * @param  string $name  Le nom du paramètre
     *
     * @return bool true si le paramètre, sinon false
     */
    public function has($name)
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Supprime un paramètre.
     *
     * @param  string $name     Le nom du paramètre
     * @param  mixed  $default  La valeur par défaut du paramètre
     *
     * @return string La valeur d'un paramètre, si le paramètre a été supprimé, sinon null
     */
    public function remove($name, $default = null)
    {
        $retval = $default;

        if(array_key_exists($name, $this->parameters))
        {
            $retval = $this->parameters[$name];
            unset($this->parameters[$name]);
        }

        return $retval;
    }

    /**
     * Renseigne un paramètre.
     *
     * Si le nom du paramètre existe déjà, celui-ci sera écraser.
     *
     * @param string $name   Le nom du paramètre
     * @param mixed  $value  La valeur du paramètre
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Renseigne un paramètre par référence.
     *
     * Si le nom du paramètre existe déjà, celui-ci sera écraser.
     *
     * @param string $name    Le nom du paramètre
     * @param mixed  $value   La valeur du paramètre
     */
    public function setByRef($name, & $value)
    {
        $this->parameters[$name] = & $value;
    }

    /**
     * Renseigne un tableau de paramètres.
     *
     * Si un nom de paramètre correspondant à une clé de tableau
     * , le paramètre sera écrasé.
     *
     * @param array $parameters  Un tableau associatif de nom de paramètres avec leur valeur
     */
    public function add($parameters)
    {
        if(null === $parameters)
        {
            return;
        }

        foreach($parameters as $key => $value)
        {
            $this->parameters[$key] = $value;
        }
    }

    /**
     * Renseigne un tableau de paramètres par référence.
     *
     * Si le nom d'un paramètre existe dans les clés du tableau, celui-ci
     * sera écrasé
     *
     * @param array $parameters  Un tableau associatif de paramètre
     */
    public function addByRef(& $parameters)
    {
        foreach($parameters as $key => &$value)
        {
            $this->parameters[$key] = & $value;
        }
    }

    /**
     * Sérialise l'instance courante.
     *
     * @return array Objects instance
     */
    public function serialize()
    {
        return serialize($this->parameters);
    }

    /**
     * Déserialise une instance de ParamterHolder.
     *
     * @param string $serialized  Une instance sérialisée de ParamaterHolder
     */
    public function unserialize($serialized)
    {
        $this->parameters = unserialize($serialized);
    }

}
