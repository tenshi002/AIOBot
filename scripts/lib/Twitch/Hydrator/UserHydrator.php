<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 01/08/17
 * Time: 14:26
 */

namespace lib\Twitch\Hydrator;


use lib\Application;
use lib\RPG\Stats;
use modeles\User;
use repositories\RoleRepository;

class UserHydrator
{
    private $display_name;
    private $_id;
    private $name;
    private $type;
    private $email;
    private $bio;
    private $created_at;
    private $updated_at;
    private $logo;

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getOrCreate(array $json)
    {
        $this->selfHydrate($json);
        $em = Application::getInstance()->getEntityManager();
        $userRepo = $em->getRepository('\modeles\User');
        $user = $userRepo->findOneBy(array('id' => $this->_id));
        if(is_null($user))
        {
            /** @var RoleRepository $roleRepo */
            $roleRepo = $em->getRepository('\modeles\Role');
            $user = new User();
            $user->setId($this->_id);
            $user->setPseudo($this->display_name);
            $user->setTwitchAccount($this->name);
            $user->setTwitchType($this->type);
            $user->setEmail($this->email);
            $user->setBio($this->bio);
            $user->setCreatedAt(new \DateTime($this->created_at));
            $user->setUpdatedAt(new \DateTime($this->updated_at));
            $user->setLogo($this->logo);
            $user->setXp(0);
            $user->setMonnaie(0);
            $user->setLevel(Stats::LEVEL_MIN);
            $user->setLife(Stats::getHP(Stats::LEVEL_MIN));
            if($user->getTwitchAccount() === Application::getInstance()->getTwitchChannel())
            {
                $role = $roleRepo->getAdminRole();
            }
            else
            {
                $role = $roleRepo->getViewerRole();
            }
            $user->addRole($role);
            $em->persist($user);
            $em->flush();
        }

        return $user;
    }

    private function selfHydrate(array $json)
    {
        foreach($json as $key => $value)
        {
            $this->$key = $value;
        }
    }
}