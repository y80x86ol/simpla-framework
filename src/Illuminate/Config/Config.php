<?php

/**
 * 配置文件类
 * 单列模式，减少请求次数
 */

namespace Illuminate\Config;

class Config {

    private static $config = '';
    private static $_instance;

    public function __construct() {
        //获取APP和系统配置文件路径
        $configAppPath = CONFIG_PATH . '/app.php';
        $configDbPath = CONFIG_PATH . '/database.php';
        $configCachePath = CONFIG_PATH . '/cache.php';

        $systemConfigAppPath = dirname(__FILE__) . '/default/app.php';
        $systemConfigDbPath = dirname(__FILE__) . '/default/database.php';
        $systemConfigCachePath = dirname(__FILE__) . '/default/cache.php';


        //引入APP配置文件
        $configApp = file_exists($configAppPath) ? require($configAppPath) : array();
        $configDb = file_exists($configDbPath) ? require($configDbPath) : array();
        $configCache = file_exists($configCachePath) ? require($configCachePath) : array();

        //引入系统配置文件
        $systemConfigApp = require($systemConfigAppPath);
        $systemConfigDb = require($systemConfigDbPath);
        $systemConfigCache = require($systemConfigCachePath);

        //合并配置文件
        $configApp = array_merge($systemConfigApp, $configApp);
        $configDb = array_merge($systemConfigDb, $configDb);
        $configCache = array_merge($systemConfigCache, $configCache);

        //进行全局变量赋值
        $GLOBALS['config']['app'] = $configApp;
        $GLOBALS['config']['database'] = $configDb;
        $GLOBALS['config']['cache'] = $configCache;
        self::$config = $GLOBALS['config'];
    }

    public function __clone() {
        trigger_error('该类不能被克隆', E_USER_ERROR);
    }

    /**
     * 初始化对象
     *
     * @return Obj 对象
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 获取所有配置
     *
     * @return array
     */
    public static function getAll() {
        return self::$config;
    }

    /**
     * 获取单个配置
     *
     * 可以采用Config::get('app.domain');的方式获取子配置
     * 
     * @param string $name 配置名字
     * @return bool|array
     */
    public static function get($name) {
        $nameArry = explode('.', $name);
        if (count($nameArry) == 1) {
            $config = self::$config[$name];
            if ($config) {
                return $config;
            }
        } elseif (count($nameArry) > 1) {
            $config = self::$config[$nameArry[0]];
            if ($config && $config[$nameArry[1]]) {
                return $config[$nameArry[1]];
            }
        }

        return false;
    }

}
