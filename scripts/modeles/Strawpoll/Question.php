<?php

/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 02/03/17
 * Time: 16:03
 */
class Question
{
    private $id;

    private $question;

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
    public function getQuestion()
    {
        return $this->question;
    }

}