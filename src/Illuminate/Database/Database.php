<?php

/*
 * 数据库处理类
 */

namespace Illuminate\Database;

use Illuminate\Config\Config;
use PDO;

class Database {

    private static $_instance;
    public static $sqlServer;

    /**
     * 初始化应用
     */
    public function __construct() {
//        $dbConfig = Config::get('database');
//        //获取数据库连接类型
//        $dbType = isset($dbConfig['default']) ? $dbConfig['default'] : 'mysql';
//        //获取数据库对应类型的配置信息
//        $sqlConfig = $dbConfig['connections'][$dbType];
        //实例化数据库，建立连接
//        $classType = ucfirst($dbType);
//        $sqlNamespaces = '\Illuminate\Database\\' . $classType;
//        $sqlObj = new $sqlNamespaces();
        //$sqlServer = $sqlObj->connect($sqlConfig);
        $sqlServer = $this->connect();

        self::$sqlServer = $sqlServer;
    }

    /**
     * 进行PDO连接
     * @return \Illuminate\Database\PDO
     */
    public function connect() {
        $dbConfig = Config::get('database');
        //获取数据库连接类型
        $dbType = isset($dbConfig['default']) ? $dbConfig['default'] : 'mysql';
        //获取数据库对应类型的配置信息
        $sqlConfig = $dbConfig['connections'][$dbType];

        //进行PDO数据库连接
        $sqlServer = new PDO('mysql:host=' . $sqlConfig['host'] . ';dbname=' . $sqlConfig['database'], $sqlConfig['username'], $sqlConfig['password']);
        return $sqlServer;
    }

    public function __clone() {
        die('该类不允许被克隆');
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

    /**
     * 获取所有查询
     *
     * @param $sql
     * @return mixed
     */
    public static function getQueryAll($sql) {
        print_r('<p>' . $sql . '</p>');
        $result = self::$sqlServer->query($sql, PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    /**
     * ִ获取一条查询
     *
     * @param $sql
     * @return array
     */
    public static function getQueryOne($sql) {
        print_r('<p>' . $sql . '</p>');

        $result = self::$sqlServer->query($sql, PDO::FETCH_ASSOC);
        return $result->fetch();
    }

    /**
     * 进行数据库变量安全处理
     * @param type $string
     */
    public static function real_escape_string($string) {
        $dbConfig = Config::get('database');
        //获取数据库连接类型
        $dbType = isset($dbConfig['default']) ? $dbConfig['default'] : 'mysql';

        //Todo:进行字符串过滤处理
        $newString = $string;
        return $newString;
    }

}
