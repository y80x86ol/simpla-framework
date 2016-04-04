<?php

/* 
 * 数据库处理类
 */

namespace Illuminate\Database;

use Illuminate\Config\Config;
use mysqli;

class Database {
	private static $_instance;
	private static $sqlServer;

	/**
	 * 初始化应用
	 */
	public function __construct() {
		$dbConfig = Config::get('database');
		//获取数据库连接类型
		$dbType = isset($dbConfig['default']) ? $dbConfig['default'] : 'mysql';
		//获取数据库对应类型的配置信息
		$sqlConfig = $dbConfig['connections'][$dbType];

		//实例化数据库，建立连接
		$classType = ucfirst($dbType);
		$sqlNamespaces = '\Illuminate\Database\\' . $classType;
		$sqlObj = new $sqlNamespaces();
		$sqlServer = $sqlObj->connect($sqlConfig);

		self::$sqlServer = $sqlServer;
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
		$sqlResult = self::$sqlServer->query($sql);

		$result = $sqlResult->fetch_all(MYSQLI_ASSOC);
		return $result;
	}

	/**
	 * ִ获取一条查询
	 *
	 * @param $sql
	 * @return array
	 */
	public static function getQueryOne($sql) {
		print_r('<p>' . $sql . '</p>');
		$sqlResult = self::$sqlServer->query($sql);

		$result = $sqlResult->fetch_assoc();
		return $result;
	}
}
