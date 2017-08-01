<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 01/08/17
 * Time: 16:04
 */

namespace modeles;


class User
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
     * @var string
     */
    private $permitLink;

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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set permitLink
     *
     * @param string $permitLink
     *
     * @return User
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

    /**
     * Add quete
     *
     * @param \modeles\Quest $quete
     *
     * @return User
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
     * @return User
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
     * @return User
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
