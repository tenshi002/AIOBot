<?php
/**
 * Created by IntelliJ IDEA.
 * User: tenshi
 * Date: 25/07/17
 * Time: 01:12
 */

namespace modeles;


class Monstre
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
     * @var integer
     */
    private $monnaie;

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
     * @return Monstre
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
     * @return Monstre
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
     * Set monnaie
     *
     * @param integer $monnaie
     *
     * @return Monstre
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
     * Add coffre
     *
     * @param \modeles\Item $coffre
     *
     * @return Monstre
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
