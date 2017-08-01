<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 01/08/17
 * Time: 14:50
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
     * @var string
     */
    private $twitchAccount;

    /**
     * @var string
     */
    private $twitchType;

    /**
     * @var string
     */
    private $bio;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var string
     */
    private $logo;

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
     * @deprecated A utiliser que pour l'affichage - Préférer getTwitchAccount()
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
     * Set twitchAccount
     *
     * @param string $twitchAccount
     *
     * @return User
     */
    public function setTwitchAccount($twitchAccount)
    {
        $this->twitchAccount = $twitchAccount;

        return $this;
    }

    /**
     * Get twitchAccount
     *
     * @return string
     */
    public function getTwitchAccount()
    {
        return $this->twitchAccount;
    }

    /**
     * Set twitchType
     *
     * @param string $twitchType
     *
     * @return User
     */
    public function setTwitchType($twitchType)
    {
        $this->twitchType = $twitchType;

        return $this;
    }

    /**
     * Get twitchType
     *
     * @return string
     */
    public function getTwitchType()
    {
        return $this->twitchType;
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return User
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
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
