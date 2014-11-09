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
		$config = new Config('test');
		$config->set('owner/name', 'alexandr');
		$this->assertEquals(array('name'=>'alexandr'), $config->get('owner'), 'deep set and get');

		$this->assertTrue($config->has('owner/name'), 'deep has works for existing key');
		$this->assertFalse($config->has('owner/last_name'), 'deep has works for non existing key');
	}
}
 