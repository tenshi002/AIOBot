<?php

namespace modeles;

/**
 * Personne
 */
class Personne
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $oauth;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $monnaie;

    /**
     * @var \modeles\Role
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $coffre;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->coffre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Personne
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set oauth
     *
     * @param string $oauth
     *
     * @return Personne
     */
    public function setOauth($oauth)
    {
        $this->oauth = $oauth;

        return $this;
    }

    /**
     * Get oauth
     *
     * @return string
     */
    public function getOauth()
    {
        return $this->oauth;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Personne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set monnaie
     *
     * @param integer $monnaie
     *
     * @return Personne
     */
    public function setMonnaie($monnaie)
    {
        $this->monnaie = $monnaie;

        return $this;
    }

    /**
     * Get monnaie
     *
     * @return integer
     */
    public function getMonnaie()
    {
        return $this->monnaie;
    }

    /**
     * Set role
     *
     * @param \modeles\Role $role
     *
     * @return Personne
     */
    public function setRole(\modeles\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \modeles\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add coffre
     *
     * @param \modeles\Item $coffre
     *
     * @return Personne
     */
    public function addCoffre(\modeles\Item $coffre)
    {
        $this->coffre[] = $coffre;

        return $this;
    }

    /**
     * Remove coffre
     *
     * @param \modeles\Item $coffre
     */
    public function removeCoffre(\modeles\Item $coffre)
    {
        $this->coffre->removeElement($coffre);
    }

    /**
     * Get coffre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoffre()
    {
        return $this->coffre;
    }
}

