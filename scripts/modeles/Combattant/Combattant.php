<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 13/03/17
 * Time: 09:22
 */

namespace modeles\Combattant;


class Combattant
{
    /**
     * @var
     */
    private $name;

    /**
     * @var int
     */
    private $life;

    private $initiative;

    public function __construct($name)
    {
        $this->name = $name;
        $this->life = 20;
        $this->initiative = random_int(1, 50);
    }

    /**
     * @return int
     */
    public function getInitiative()
    {
        return $this->initiative;
    }

    /**
     * @return int
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @param int $life
     */
    public function setLife($life)
    {
        $this->life = $life;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}