<?php

namespace modeles;

/**
 * Item
 */
class Item
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
     * @var integer
     */
    private $value;

    /**
     * @var integer
     */
    private $damage;

    /**
     * @var integer
     */
    private $heal;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Item
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Item
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
     * Set value
     *
     * @param integer $value
     *
     * @return Item
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set damage
     *
     * @param integer $damage
     *
     * @return Item
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage
     *
     * @return integer
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set heal
     *
     * @param integer $heal
     *
     * @return Item
     */
    public function setHeal($heal)
    {
        $this->heal = $heal;

        return $this;
    }

    /**
     * Get heal
     *
     * @return integer
     */
    public function getHeal()
    {
        return $this->heal;
    }
}
