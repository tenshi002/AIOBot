<?php

namespace modeles;

/**
 * Role
 */
class Role
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $personnes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Role
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add personne
     *
     * @param \modeles\Personne $personne
     *
     * @return Role
     */
    public function addPersonne(\modeles\Personne $personne)
    {
        $this->personnes[] = $personne;

        return $this;
    }

    /**
     * Remove personne
     *
     * @param \modeles\Personne $personne
     */
    public function removePersonne(\modeles\Personne $personne)
    {
        $this->personnes->removeElement($personne);
    }

    /**
     * Get personnes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;


    /**
     * Add user
     *
     * @param \modeles\User $user
     *
     * @return Role
     */
    public function addUser(\modeles\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \modeles\User $user
     */
    public function removeUser(\modeles\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
