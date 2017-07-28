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
     * @var integer
     */
    private $life;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $quetes;

    /**
     * @var \modeles\Role
     */
    private $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $coffre;

    /**
     * @var string
     */
    private $permitLink;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quetes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set life
     *
     * @param integer $life
     *
     * @return Personne
     */
    public function setLife($life)
    {
        $this->life = $life;

        return $this;
    }

    /**
     * Get life
     *
     * @return integer
     */
    public function getLife()
    {
        return $this->life;
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
     * Add quete
     *
     * @param \modeles\Quest $quete
     *
     * @return Personne
     */
    public function addQuete(\modeles\Quest $quete)
    {
        $this->quetes[] = $quete;

        return $this;
    }

    /**
     * Remove quete
     *
     * @param \modeles\Quest $quete
     */
    public function removeQuete(\modeles\Quest $quete)
    {
        $this->quetes->removeElement($quete);
    }

    /**
     * Get quetes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuetes()
    {
        return $this->quetes;
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

    /**
     * Set permitLink
     *
     * @param string $permitLink
     *
     * @return Personne
     */
    public function setPermitLink($permitLink)
    {
        $this->permitLink = $permitLink;

        return $this;
    }

    /**
     * Get permitLink
     *
     * @return string
     */
    public function getPermitLink()
    {
        return $this->permitLink;
    }
}
