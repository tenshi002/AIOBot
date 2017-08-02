<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 02/08/17
 * Time: 17:15
 */

namespace Commandes;


use lib\Application;
use modeles\User;
use repositories\UserRepository;

class Permit
{
    public function executeAction($args)
    {
        $entityManager = Application::getInstance()->getEntityManager();
        /** @var $userRepository UserRepository*/
        $userRepository = $entityManager->getRepository('modeles\User');

        /** @var $user User*/
        $user = $userRepository->findOneBy(array('twitchAccount', $args[0]));

        $user->setPermitLink(true);
        //TODO on affiche un message de confirmation dans le chat ?
    }
}