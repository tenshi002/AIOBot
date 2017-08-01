<?php
/**
 * Created by IntelliJ IDEA.
 * User: nico
 * Date: 01/08/17
 * Time: 16:06
 */

namespace lib\RPG;


class Stats
{
    const LEVEL_MIN = 1;
    const LEVEL_MAX = 100;

    public static function getHP($level)
    {
        return 500 + ($level * 10);
    }

    public static function getDamages($level)
    {
        $dmg = 10 + ($level / 10);
        if(!self::isHit($level))
        {
            return 0;
        }
        if(self::isCritical($level))
        {
            return $dmg * 1.5;
        }
        return $dmg;
    }

    public static function isHit($level)
    {
        return rand(1, 100) < (70 + ($level / 5));
    }

    public function isCritical($level)
    {
        return rand(1,100) < (5 + $level / 5);
    }

    public static function getXPAmountToLevelUp($currentLevel)
    {
        if($currentLevel === self::LEVEL_MAX)
        {
            return -1;
        }
        return $currentLevel * 100 + 1000;
    }

    public static function getAmoutXPFromBoss($bossLevel)
    {
        return $bossLevel * 5;
    }


}