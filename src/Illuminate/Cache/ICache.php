<?php

/**
 * 缓存接口类
 */

namespace Illuminate\Cache;

use Illuminate\Config\Config;
use Illuminate\Filesystem\Filesystem;
use phpFastCache\CacheManager;

class ICache {

    private static $_instance;
    public static $cache;

    public function __construct() {
        $cacheConfig = Config::get('cache');
        switch ($cacheConfig['fileSystem']) {
            case 'file':
                $cache = self::file($cacheConfig['file']);
                break;
            case 'memcache':
                $cache = self::memcache($cacheConfig['memcache']);
                break;
            case 'memcached':
                $cache = self::memcached($cacheConfig['memcached']);
                break;
            case 'redis':
                $cache = self::redis($cacheConfig['redis']);
                break;
            case 'apc':
                $cache = self::apc();
                break;
            default:
                $cache = self::file($cacheConfig['file']);
        }

        self::$cache = $cache;
    }

    /**
     * 单列模式，初始化缓存
     *
     * @return Obj
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 文件缓存
     *
     * @param array $config 配置参数
     * @return \phpFastCache\Core\DriverAbstract
     */
    private function file($config = array()) {
        $filePath = $config['filePath'];

        if (!file_exists($filePath)) {
            Filesystem::mkdir($filePath);
        }
        //初始化缓存路径
        CacheManager::setup(array(
            "path" => isset($filePath) ? $filePath : sys_get_temp_dir(), // or in windows "C:/tmp/"
        ));
        CacheManager::CachingMethod("phpfastcache");

        //初始化缓存
        $InstanceCache = CacheManager::Files();

        return $InstanceCache;
    }

    /**
     * memcache缓存
     *
     * @param array $config 配置参数
     * @return \phpFastCache\Core\DriverAbstract
     */
    private function memcache($config = array()) {
        CacheManager::setup(array(
            'memcache' => array(
                $config
            ),
        ));
        $InstanceCache = CacheManager::Memcache();

        return $InstanceCache;
    }

    /**
     * memcached缓存
     *
     * @param array $config 配置参数
     * @return \phpFastCache\Core\DriverAbstract
     */
    private function memcached($config = array()) {
        CacheManager::setup(array(
            'memcache' => array(
                $config
            ),
        ));
        $InstanceCache = CacheManager::Memcached();

        return $InstanceCache;
    }

    /**
     * redis缓存
     *
     * @param array $config 配置参数
     * @return \phpFastCache\Core\DriverAbstract
     */
    private function redis($config = array()) {
        CacheManager::setup(array(
            'redis' => array(
                $config
            ),
        ));
        $InstanceCache = CacheManager::Redis();

        return $InstanceCache;
    }

    /**
     * apc缓存
     *
     * @param array $config 配置参数
     * @return \phpFastCache\Core\DriverAbstract
     */
    private function apc() {
        $InstanceCache = CacheManager::getInstance('apc');

        return $InstanceCache;
    }

}
