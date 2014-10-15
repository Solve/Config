<?php
/*
 * This file is a part of Solve framework.
 *
 * @author Alexandr Viniychuk <alexandr.viniychuk@icloud.com>
 * @copyright 2009-2014, Alexandr Viniychuk
 * created: 15.10.14 11:39
 */

namespace Solve\Config\Tests;

require_once __DIR__ . '/../ConfigService.php';
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Solve\Config\ConfigService;

class ConfigServiceTest extends \PHPUnit_Framework_TestCase {

    private static $_configPath;

    public function testBasic() {
        ConfigService::setConfigsPath(self::$_configPath);
        $this->assertEquals(self::$_configPath, ConfigService::getConfigsPath(), 'Config path set correctly');

        $projectConfig = ConfigService::getConfig('project');
        $this->assertInstanceOf('\\Solve\\Config\\Config', $projectConfig, 'Service returned new instance of Config');

        $this->assertEquals('project', $projectConfig->getName(), 'Loaded correct config by name');
        $this->assertEquals('test', $projectConfig->get('project_name'), 'Data from project.yml');
        $this->assertEquals(false, $projectConfig->get('dev_mode'), 'General value loaded');

        ConfigService::loadEnvironment('local');
        $this->assertEquals(true, $projectConfig->get('dev_mode'), 'Local value loaded');

        ConfigService::loadEnvironment('youshido.com');
        $this->assertEquals(false, $projectConfig->get('dev_mode'), 'Overriden value loaded');
        ConfigService::loadEnvironment('local');

        $projectConfig->set('project_name', 'config test');
        $this->assertEquals('config test', $projectConfig->get('project_name'), 'update key in memory');

        $projectConfig->save();
    }

    public static function setUpBeforeClass() {
        self::$_configPath = __DIR__ . '/assets/';
        $originalProjectConfig = <<<TEXT
project_name: test
dev_mode: false
TEXT;
        if (is_dir(self::$_configPath)) {
            self::unlinkRecursive(self::$_configPath);
        }
        mkdir(self::$_configPath);
        file_put_contents(self::$_configPath . 'project.yml', $originalProjectConfig);

        mkdir(self::$_configPath . 'local/');
        file_put_contents(self::$_configPath . 'local/project.yml', 'dev_mode: true');

        mkdir(self::$_configPath . 'youshido.com/');
        file_put_contents(self::$_configPath . 'youshido.com/project.yml', 'dev_mode: false');
    }

    public static function tearDownAfterClass() {
        self::unlinkRecursive(self::$_configPath);
    }


    static public function unlinkRecursive($path) {
        if (!file_exists($path)) return true;
        if (!is_dir($path) || is_link($path)) return unlink($path);

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!self::unlinkRecursive($path . "/" . $item)) {
                chmod($path . "/" . $item, 0777);
                if (!self::unlinkRecursive($path . "/" . $item)) return false;
            };
        }
        return rmdir($path);
    }


}
 