<?php
/*
 * This file is a part of Solve framework.
 */


namespace Solve\Config;

/**
 * Class Config
 * @package Solve\Config
 *
 * Class Config is used to operate with config files
 * @version 1.1
 */

class Config {

	static private $_environment = false;

	public function __constructor() {}


	public static function getConfig($configName, $field = null) {

	}

	public static function setConfig($configName, $field, $value) {

	}

	public function getDefaultEnvironment() {

	}

	public function getEnvironment() {
		return self::$_environment;
	}

	public function setEnvironment($environment) {
		return self::$_environment = $environment;
	}


	public function save() {

	}

	public function getDeepArrayValue() {

	}





}