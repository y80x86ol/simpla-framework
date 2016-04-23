<?php

/*
 * 路由帮助类
 */

namespace Illuminate\Route;

use Illuminate\Str\String;
use Illuminate\Config\Config;
use Illuminate\Domain\Domain;

class RouteHandle {

    /**
     * 处理路由，获取控制器和执行方法
     *
     * @return array
     */
    public static function getRoute() {
        //获取请求URL
        $requestUrlArr = self::getRouteString();

        //处理请求URL
        if (count($requestUrlArr) == 1) {//dev.example.com/aaa
            $data = array(array(
                    'act' => !empty($requestUrlArr[0]) ? $requestUrlArr[0] : 'index',
                    'op' => 'actionIndex',
                    'namespace' => ''
            ));
        } elseif (count($requestUrlArr) >= 2) {//dev.example.com/aaa/bbb //dev.example.com/aaa/bbb/index
            $origRequestUrlArr = $requestUrlArr;
            $lastParam = array_pop($requestUrlArr);
            if ($lastParam == 'index') {
                $data = array(array(
                        'act' => array_pop($requestUrlArr),
                        'op' => 'actionIndex',
                        'namespace' => implode('/', $requestUrlArr)
                ));
            } else {
                $data = array(
                    array(
                        'act' => array_pop($origRequestUrlArr),
                        'op' => 'actionIndex',
                        'namespace' => implode('/', $origRequestUrlArr),
                    ),
                    array(
                        'act' => array_pop($requestUrlArr),
                        'op' => 'action' . ucfirst($lastParam),
                        'namespace' => implode('/', $requestUrlArr),
                    )
                );
            }
        }

        return $data;
    }

    /**
     * 处理路由，获取控制器和执行方法
     *
     * @return array
     */
    public static function getModuleRoute() {
        //获取请求URL
        $requestUrlArr = self::getRouteString();

        //处理请求URL
        if (count($requestUrlArr) == 1) {//dev.example.com/aaa
            $data = array(array(
                    'module' => $requestUrlArr[0],
                    'act' => 'index',
                    'op' => 'actionIndex',
                    'namespace' => ''
            ));
        } elseif (count($requestUrlArr) == 2) {//dev.example.com/aaa/bbb
            $data = array(array(
                    'module' => $requestUrlArr[0],
                    'act' => $requestUrlArr[1],
                    'op' => 'actionIndex',
                    'namespace' => ''
            ));
        } elseif (count($requestUrlArr) == 3) {//dev.example.com/aaa/bbb
            $data = array(array(
                    'module' => $requestUrlArr[0],
                    'act' => $requestUrlArr[1],
                    'op' => 'action' . ucfirst($requestUrlArr[2]),
                    'namespace' => ''
                ),
                array(
                    'module' => $requestUrlArr[0],
                    'act' => $requestUrlArr[2],
                    'op' => 'actionIndex',
                    'namespace' => $requestUrlArr[1]
            ));
        } elseif (count($requestUrlArr) >= 4) {//dev.example.com/aaa/bbb/ccc //dev.example.com/aaa/bbb/ccc/index
            $module = array_shift($requestUrlArr); //第一个元素即为module名字
            $origRequestUrlArr = $requestUrlArr;
            $lastParam = array_pop($requestUrlArr);

            if ($lastParam == 'index') {
                $data = array(array(
                        'module' => $module,
                        'act' => array_pop($requestUrlArr),
                        'op' => 'actionIndex',
                        'namespace' => implode('/', $requestUrlArr)
                ));
            } else {
                $data = array(
                    array(
                        'module' => $module,
                        'act' => array_pop($origRequestUrlArr),
                        'op' => 'actionIndex',
                        'namespace' => implode('/', $origRequestUrlArr),
                    ),
                    array(
                        'module' => $module,
                        'act' => array_pop($requestUrlArr),
                        'op' => 'action' . ucfirst($lastParam),
                        'namespace' => implode('/', $requestUrlArr),
                    )
                );
            }
        }

        return $data;
    }

    private static function getRouteString() {
        //获取请求URL
        $requestUrl = ltrim(rtrim($_SERVER['REQUEST_URI'], '/'), '/');

        //处理特殊情况，去掉index.php/
        if (substr($requestUrl, 0, 9) == 'index.php') {
            $requestUrl = substr($requestUrl, 10);
        }

        //去除?以后的所有参数
        $requestUrl = String::urlSafetyFilter($requestUrl);
        $requestUrlArr = explode('?', $requestUrl);

        //处理请求URL
        $requestUrlArr = explode('/', $requestUrlArr[0]);

        if (count($requestUrlArr) == 0) {
            error_404();
        }

        $requestUrlArr = self::secondDomainFilter($requestUrlArr);

        return $requestUrlArr;
    }

    /**
     * 获取模块名字
     */
    public static function getModuleName() {
        //获取请求URL
        $requestUrlArr = self::getRouteString();
        $module = array_shift($requestUrlArr);
        return $module;
    }

    /**
     * 二级域名路由追加处理
     * 
     * 如果存在二级域名，则对路由头部插入二级域名标示。
     * 
     * @param array $requestUrlArr 路由数组
     * @return array   增加了二级域名标示的路由数组
     */
    private static function secondDomainFilter($requestUrlArr) {
        $domain = Domain::getSecondDomain();
        $domainConfig = Config::get('app.domain');

        //判断是否是二级域名访问
        if (isset($domainConfig[$domain])) {
            $domainPointer = $domainConfig[$domain];
            if (empty($requestUrlArr[0])) {
                $requestUrlArr[0] = $domainPointer;
            } else {
                array_unshift($requestUrlArr, $domainPointer);
            }
        }
        return $requestUrlArr;
    }

}
