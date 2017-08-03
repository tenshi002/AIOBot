<?php

namespace lib;

use modeles\User;

class Cookie
{
    const USER_KEY = 'uk';
    const TOKEN_KEY = 'tk';

    public static function getCookie($name)
    {
        if(isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        return null;
    }

    public static function setCookie($name, $value, $time = null)
    {
        if(is_null($time))
        {
            $time = time() + 60*60*24*30;
        }
        setcookie($name, $value, $time);
    }

    public static function deleteCookie($name)
    {
        self::setCookie($name, '', time()-1);
    }

    public static function saveUserCookie(User $user)
    {
        self::setCookie(self::USER_KEY, $user->getId());
        self::setCookie(self::TOKEN_KEY, $user->getToken());
    }

    public static function loadUserFromCookie()
    {
        $userId = self::getCookie(self::USER_KEY);
        $userToken = self::getCookie(self::TOKEN_KEY);
        $userRepo = Application::getInstance()->getEntityManager()->getRepository('\modeles\User');
        return $userRepo->findOneBy(array(
            'id' => $userId,
            'token' => $userToken
        ));
    }

}