<?php

namespace lib;

use Zend\Config\Reader\Ini;


/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 03/03/17
 * Time: 15:39
 */
class Configuration
{

    /**
     * Retourne le fichier ini sous forme de tableau
     * @var $configuration
     */
    private $configuration;
    private $pathConfig = __DIR__ . '/../../configurations/configurateurs.ini';

    public function initContainer()
    {
        $configIni = new Ini();
        $this->configuration = $configIni->fromFile($this->pathConfig);
    }

    /**
     * @param $names
     * @return bool|string
     */
    public function get($names)
    {
        $keys = explode('.', $names);

        return $this->getConfigurationValue($this->configuration, $keys);

    }

    /**
     * @param $arrays array tableau dans lequel rechercher les données à partir des clés
     * @param $keys array tableau à une dimension contenant les clés
     * @return bool|string
     */
    private function getConfigurationValue($arrays, $keys)
    {
        foreach($keys as $key => $value)
        {
            if(is_array($arrays[$value]) && !empty($arrays[$value]))
            {
                $newKeys = $keys;
                unset($newKeys[$key]);
                return $this->getConfigurationValue($arrays[$value], $newKeys);
            }
            else
            {
                return $arrays[$value];
            }
        }
        return false;
    }

    /**
     * @return
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }



}