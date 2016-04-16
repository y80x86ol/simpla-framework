<?php

/*
 * 模块类
 */

namespace Illuminate\Http;

use ActiveRecord\Config;
use Illuminate\Config\Config as simplaConfig;

class Model {

    private static $_instance;

    public function __construct() {
        $this->connect();
    }

    /**
     * 静态初始化应用
     *
     * @return obj 缓存对象
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function connect() {
        Config::initialize(function($cfg) {
            $modelDirectory = APP_PATH . '/Models';
            $configInfo = $this->getConnectType();
            $cfg->set_model_directory($modelDirectory);
            $cfg->set_connections(array(
                'development' => $configInfo));
        });
    }

    private function getConnectType() {
        $dbConfig = simplaConfig::get('database');
        //获取数据库连接类型
        $dbType = isset($dbConfig['default']) ? $dbConfig['default'] : 'mysql';
        //获取数据库对应类型的配置信息
        $sqlConfig = $dbConfig['connections'][$dbType];

        $configInfo = 'mysql://' . $sqlConfig['username'] . ':' . $sqlConfig['password'] . '@' . $sqlConfig['host'] . '/' . $sqlConfig['database'];
        return $configInfo;
    }

}
