<?php
/*
 * This file is a part of Solve framework.
 */


namespace Solve\Config;
use Solve\Storage\ArrayStorage;
use Solve\Storage\YamlStorage;

/**
 * Class Config
 * @package Solve\Config
 *
 * Class Config is used to operate with config files
 * @version 1.1
 */

class Config {

    private $_path;
    /**
     * @var YamlStorage
     */
    private $_originalData;
    /**
     * @var YamlStorage
     */
    private $_environmentData;

    /**
     * @var ArrayStorage
     */
    private $_combinedData;

    private $_loadedEnvironmentName;
    private $_name;

    public function __construct($configName) {
        $this->_path = ConfigService::getConfigsPath() . $configName . '.yml';
        $this->_name = $configName;
        $this->load();
    }

    public function load() {
        $this->_originalData = new YamlStorage($this->_path);
        $this->_combinedData = new ArrayStorage($this->_originalData->getData());
        if (!empty($this->_loadedEnvironmentName)) {
            $this->loadEnvironment($this->_loadedEnvironmentName);
        }
        return $this;
    }

    public function save() {
        $this->_originalData->flush();
        if (!empty($this->_environmentData)) {
            $this->_environmentData->flush();
        }
        return $this;
    }

    public function loadEnvironment($environmentName) {
        $environmentPath = ConfigService::getConfigsPath() . $environmentName . '/' . $this->_name . '.yml';
        $this->_loadedEnvironmentName = $environmentName;
        if (is_file($environmentPath)) {
            $this->_environmentData = new YamlStorage($environmentPath);
            $this->_combinedData->extendDeepValue($this->_environmentData->getData());
        }
        return $this;
    }

    public function get($deepKey, $defaultValue = null) {
        return $this->_combinedData->getDeepValue($deepKey, $defaultValue);
    }

    public function getData() {
        return $this->_combinedData->getData();
    }

    public function set($deepKey, $value, $toEnvironment = null) {
        //@todo hasDeepKey
        if ($this->_environmentData && ($this->_environmentData->has($deepKey) && ($toEnvironment !== false)) || ($toEnvironment === true)) {
            $this->_environmentData->setDeepValue($deepKey, $value);
        } else {
            $this->_originalData->setDeepValue($deepKey, $value);
        }
        $this->_combinedData->setDeepValue($deepKey, $value);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->_name;
    }

    public function getPath() {
        return $this->_path;
    }

}