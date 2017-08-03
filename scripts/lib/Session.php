<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 02/08/17
 * Time: 15:41
 */

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
    public function getUser()
    {
        $userId = $this->getAttribute(self::USER);
        $em = Application::getInstance()->getEntityManager();
        /** @var UserRepository $userRepo */
        $userRepo = $em->getRepository('\modeles\User');
        $user = $userRepo->findOneBy(array('id' => $userId));
        return $user;
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

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $_SESSION;
    }

}