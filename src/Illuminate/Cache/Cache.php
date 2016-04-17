<?php

/**
 * 缓存类
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
     * 初始化
     */
    public function __construct() {
        self::$cache = ICache::$cache;
    }

    /**
     * 静态初始化
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
     * 设置缓存
     *
     * @param string $name 键名
     * @param string $value 键值
     * @param int $time 缓存时间
     */
    public static function set($name, $value, $time = 0) {
        self::$cache->set($name, $value, $time);
    }

    /**
     * 获取缓存
     *
     * @param string $name 键名
     * @return string
     */
    public static function get($name) {
        return self::$cache->get($name);
    }

    /**
     * 获取缓存信息
     * @param string $name 键名
     * @return null|object
     */
    public static function getInfo($name) {
        return self::$cache->getInfo($name);
    }

    /**
     * 删除缓存
     * @param $name        键名
     */
    public static function delete($name) {
        self::$cache->delete($name);
    }

    /**
     * 清除所有缓存
     */
    public static function flush() {
        self::$cache->flush();
    }

    /**
     * 增加指定$num
     *
     * @param string $name 键名
     * @param int $num 增加的值
     */
    public static function increment($name, $num = 1) {
        self::$cache->increment($name, $num);
    }

    /**
     * 减少指定$num
     *
     * @param string $name 键名
     * @param int $num 减少的值
     */
    public static function decrement($name, $num = 1) {
        self::$cache->decrement($name, $num);
    }

    /**
     * 检查缓存是否存在
     *
     * @param string $name 键名
     * @return bool
     */
    public static function isExisting($name) {
        return self::$cache->isExisting($name);
    }

    /**
     * =====================================================
     * 批量操作
     * =====================================================
     */

    /**
     * 批量获取缓存
     * example：$data = array("key1", "key2", "key3");
     *
     * @param array $data
     * @return array
     */
    public static function getMulti($data = array()) {
        return self::$cache->getMulti($data);
    }

    /**
     * 批量设置缓存
     * example：
     * array("key1","value1", 300),
     * array("key2","value2", 600),
     * array("key3","value3", 1800),
     */
    public static function setMulti() {
        $data = func_get_args();
        self::$cache->setMulti($data);
    }

}
