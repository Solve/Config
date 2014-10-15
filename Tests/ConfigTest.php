<?php
/**
 * Created by PhpStorm.
 * User: serzh
 * Date: 10/1/14
 * Time: 16:36
 */

namespace Solve\Config\Tests;


use Solve\Config\Config;

require_once __DIR__.'/../Config.php';
require_once __DIR__.'/../vendor/autoload.php';

class ConfigTest extends \PHPUnit_Framework_TestCase {

	public function testMain() {
		$instance = new Config();

		//set
		//get

		$this->assertTrue(true, 'Constructor test');
	}
}
 