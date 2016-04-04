<?php
/**
 * ������
 * User: ken
 * Date: 2016/3/28 0028
 * Time: 2016 6:27
 */

namespace Illuminate\Cache;

use Illuminate\Cache\ICache;


class Cache {
	private static $_instance;
	private static $cache;

	/**
	 * ��ʼ��
	 */
	public function __construct() {
		self::$cache = ICache::$cache;
	}

	/**
	 * ��̬��ʼ��
	 *
	 * @return Cache
	 */
	public static function getInstance() {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * ���û���
	 *
	 * @param string $name ����
	 * @param string $value ��ֵ
	 * @param int $time ����ʱ��
	 */
	public static function set($name, $value, $time = 0) {
		self::$cache->set($name, $value, $time);
	}

	/**
	 * ��ȡ����
	 *
	 * @param string $name ����
	 * @return string
	 */
	public static function get($name) {
		return self::$cache->get($name);
	}

	/**
	 * ��ȡ������Ϣ
	 * @param string $name ����
	 * @return null|object
	 */
	public static function getInfo($name) {
		return self::$cache->getInfo($name);
	}

	/**
	 * ɾ������
	 * @param $name        ����
	 */
	public static function delete($name) {
		self::$cache->delete($name);
	}

	/**
	 * ������л���
	 */
	public static function flush() {
		self::$cache->flush();
	}

	/**
	 * ����ָ��$num
	 *
	 * @param string $name ����
	 * @param int $num ���ӵ�ֵ
	 */
	public static function increment($name, $num = 1) {
		self::$cache->increment($name, $num);
	}

	/**
	 * ����ָ��$num
	 *
	 * @param string $name ����
	 * @param int $num ���ٵ�ֵ
	 */
	public static function decrement($name, $num = 1) {
		self::$cache->decrement($name, $num);
	}

	/**
	 * ��黺���Ƿ����
	 *
	 * @param string $name ����
	 * @return bool
	 */
	public static function isExisting($name) {
		return self::$cache->isExisting($name);
	}

	/**
	 * =====================================================
	 * ��������
	 * =====================================================
	 */
	/**
	 * ������ȡ����
	 * example��$data = array("key1", "key2", "key3");
	 *
	 * @param array $data
	 * @return array
	 */
	public static function getMulti($data = array()) {
		return self::$cache->getMulti($data);
	}

	/**
	 * �������û���
	 * example��
	 * array("key1","value1", 300),
	 * array("key2","value2", 600),
	 * array("key3","value3", 1800),
	 */
	public static function setMulti() {
		$data = func_get_args();
		self::$cache->setMulti($data);
	}
}