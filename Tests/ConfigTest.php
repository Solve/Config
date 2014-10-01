<?php
/**
 * Created by PhpStorm.
 * User: serzh
 * Date: 10/1/14
 * Time: 16:36
 */

namespace Solve\Config\Tests;


use Solve\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

	public function testMain() {
		$instance = new Config();
		$this->assertInstanceOf('Config', $instance, 'Constructor test');
	}
}
 