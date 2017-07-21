<?php

namespace modeles;

/**
 * Texte
 */
class Texte
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \modeles\Commande
     */
    private $text;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Texte
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
     * Set text
     *
     * @param \modeles\Commande $text
     *
     * @return Texte
     */
    public function setText(\modeles\Commande $text = null)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return \modeles\Commande
     */
    public function getText()
    {
        return $this->text;
    }
}
