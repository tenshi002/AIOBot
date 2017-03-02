<?php

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 02/03/17
 * Time: 16:04
 */
class choix
{
    private $id;

    private $choix;

    private $counter;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getChoix()
    {
        return $this->choix;
    }

    /**
     * @param mixed $choix
     */
    public function setChoix($choix)
    {
        $this->choix = $choix;
    }

    /**
     * @return mixed
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @param mixed $counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }


}