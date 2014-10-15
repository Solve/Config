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
 * @author  Sergey Evtyshenko <s.evtyshenko@gmail.com>
 */

class ConfigService {

	static private $_configs = null;

	static private $_projectPath = false;

	public static function getConfig($name) {
		if (!array_key_exists($name, self::$_configs)) {
//			self::$_configs[$name] = Config::getConfig($name);
		}

		return self::$_configs[$name];
	}

	public static function loadEnvironmentConfig($configName, $domain) {
		self::$_configs[$configName]->setEnvironment($domain);

	}

	public static function getEnvironmentConfig($configName, $domain) {

	}

	public function setProjectPath($path){
		self::$_projectPath = $path;
	}

	public static function __call() {

	}
} 