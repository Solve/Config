<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Sergey Evtyshenko <s.evtyshenko@gmail.com>
 * @copyright 2009-2014, Sergey Evtyshenko
 * created: 10/14/14 17:06
 */


namespace Solve\Config;

/**
 * Class ConfigService
 *
 * @package Solve\Config
 *
 * Class ConfigService is used to operate with config objects
 *
 * @version 1.0
 * @author Sergey Evtyshenko <s.evtyshenko@gmail.com>
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 */

class ConfigService {

    private static $_loadedConfigs          = array();
    private static $_currentEnvironmentName = 'local';

    private static $_configsPath;

    /**
     * @param string $configName
     * @param string $environmentName
     * @return Config
     * @throws \Exception
     */
    public static function getConfig($configName, $environmentName = null) {
        if (empty(self::$_loadedConfigs[$configName])) {
            self::loadConfig($configName);
        }
        if (!empty($environmentName)) {
            self::loadEnvironment($environmentName, $configName);
        }
        return self::$_loadedConfigs[$configName];
    }

    public static function loadConfig($configName) {
        if (empty(self::$_configsPath)) throw new \Exception('Base path not defined for configs');

        self::$_loadedConfigs[$configName] = new Config($configName);
    }

    public static function loadEnvironment($environmentName, $configName = null) {
        if (!is_dir(self::$_configsPath . $environmentName)) throw new \Exception('Environment path does not exist: '.$environmentName);
        if (empty($configName)) {
            self::loadAllConfigs();
        }
        self::$_currentEnvironmentName = $environmentName;

        if (!empty($configName)) {
            $configsToUpdate = array($configName);
        } else {
            $configsToUpdate = array_keys(self::$_loadedConfigs);
        }

        foreach($configsToUpdate as $configName) {
            /**
             * @var Config $configInstance
             */
            $configInstance = self::$_loadedConfigs[$configName];
            $configInstance->loadEnvironment($environmentName);
        }
    }

    public static function loadAllConfigs() {
        $files = GLOB(self::getConfigsPath() . '*.yml');
        if (!empty($files)) {
            foreach ($files as $fileName) {
                self::loadConfig(substr($fileName, strrpos($fileName, DIRECTORY_SEPARATOR)+1, strrpos($fileName, '.yml')-strlen($fileName)));
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getConfigsPath() {
        return self::$_configsPath;
    }

    /**
     * @param mixed $configsPath
     */
    public static function setConfigsPath($configsPath) {
        self::$_configsPath = $configsPath;
    }

    /**
     * @return string
     */
    public static function getCurrentEnvironmentName() {
        return self::$_currentEnvironmentName;
    }

}