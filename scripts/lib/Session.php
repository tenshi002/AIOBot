<?php

namespace lib;

use modeles\User;
use repositories\UserRepository;

class Session
{
    const USER = 'user';
    const LOGGED_IN = 'logged';
    const TWITCH_CODE = 'tcode';
    const TWITCH_ACCESS_TOKEN = 'tat';
    const TWITCH_REFRESH_TOKEN = 'trt';
    const FLASHMESSAGE = 'flashMessage';

    public function destroy()
    {
        session_destroy();
    }

    /**
     * @param $key
     * @param $value
     */
    public function addattribute($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @return User
     */
    public function getUserFromSession()
    {
        $userId = $this->getAttribute(self::USER);
        if(is_null($userId))
        {
            return null;
        }
        $em = Application::getInstance()->getEntityManager();
        /** @var UserRepository $userRepo */
        $userRepo = $em->getRepository('\modeles\User');
        $user = $userRepo->findOneBy(array('id' => $userId));
        return $user;
    }

    public function addFlashMessage($title, $text, $type)
    {
        if(is_string($title) && is_string($text) && is_string($type))
        {
            $flashMessage = array(
                'title' => $title,
                'message' => $text,
                'type' => $type
            );
            $this->addattribute(self::FLASHMESSAGE, $flashMessage);
        }
    }

    public function resetFlashMessage()
    {
        $this->unsetAttribute(self::FLASHMESSAGE);
    }

    public function getFlashMessage()
    {
        if(!is_null($this->getAttribute(self::FLASHMESSAGE)))
        {
            return $this->getAttribute(self::FLASHMESSAGE);
        }
        return null;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        if(isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        return null;
    }

    public function unsetAttribute($key)
    {
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $_SESSION;
    }

}