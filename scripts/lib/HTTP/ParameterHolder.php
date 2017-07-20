<?php

namespace lib\HTTP;
use Serializable;

/**
 * Classe basique pour la gestion de param�tres des requetes
 */
class ParameterHolder implements Serializable
{

    /**
     * Les param�tres de cette requ�te
     *
     * @var array un tableau de param�tres
     */
    protected $parameters = array();

    /**
     * Le constructeur de ParameterHolder.
     */
    public function __construct()
    {

    }

    /**
     * Efface tous les param�tres associ�s � la requete.
     */
    public function clear()
    {
        $this->parameters = array();
    }

    /**
     * Recup�re un param�tre.
     *
     * @param  string $name     Le nom d'un param�tre
     * @param  mixed  $default  La valeur par d�faut du param�tre
     *
     * @return mixed La valeur d'un param�tre s'il existe, null sinon
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
     * Retourne un tableau de nom de param�tres.
     *
     * @return array Un tbaleau inde� de noms de param�tres
     */
    public function getNames()
    {
        return array_keys($this->parameters);
    }

    /**
     * Recup�re tous les param�tres dans un tableau.
     *
     * @return array Un tableau associatif de param�tres
     */
    public function & getAll()
    {
        return $this->parameters;
    }

    /**
     * Indique si un param�tre existe ou non.
     *
     * @param  string $name  Le nom du param�tre
     *
     * @return bool true si le param�tre, sinon false
     */
    public function has($name)
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Supprime un param�tre.
     *
     * @param  string $name     Le nom du param�tre
     * @param  mixed  $default  La valeur par d�faut du param�tre
     *
     * @return string La valeur d'un param�tre, si le param�tre a �t� supprim�, sinon null
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
     * Renseigne un param�tre.
     *
     * Si le nom du param�tre existe d�j�, celui-ci sera �craser.
     *
     * @param string $name   Le nom du param�tre
     * @param mixed  $value  La valeur du param�tre
     */
    public function set($name, $value)
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Renseigne un param�tre par r�f�rence.
     *
     * Si le nom du param�tre existe d�j�, celui-ci sera �craser.
     *
     * @param string $name    Le nom du param�tre
     * @param mixed  $value   La valeur du param�tre
     */
    public function setByRef($name, & $value)
    {
        $this->parameters[$name] = & $value;
    }

    /**
     * Renseigne un tableau de param�tres.
     *
     * Si un nom de param�tre correspondant � une cl� de tableau
     * , le param�tre sera �cras�.
     *
     * @param array $parameters  Un tableau associatif de nom de param�tres avec leur valeur
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
     * Renseigne un tableau de param�tres par r�f�rence.
     *
     * Si le nom d'un param�tre existe dans les cl�s du tableau, celui-ci
     * sera �cras�
     *
     * @param array $parameters  Un tableau associatif de param�tre
     */
    public function addByRef(& $parameters)
    {
        foreach($parameters as $key => &$value)
        {
            $this->parameters[$key] = & $value;
        }
    }

    /**
     * S�rialise l'instance courante.
     *
     * @return array Objects instance
     */
    public function serialize()
    {
        return serialize($this->parameters);
    }

    /**
     * D�serialise une instance de ParamterHolder.
     *
     * @param string $serialized  Une instance s�rialis�e de ParamaterHolder
     */
    public function unserialize($serialized)
    {
        $this->parameters = unserialize($serialized);
    }

}
