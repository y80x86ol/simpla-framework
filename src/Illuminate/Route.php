<?php

/*
 * 路由
 */

namespace Illuminate;

use Illuminate\Http\Request;

class Route {

    /**
     * 路由检查
     */
    public static function check() {
        //获取控制器和方法
        $route = Request::getRoute();
        foreach ($route as $item) {
            $act = $item['act'];
            $op = $item['op'];
            $namespaces = $item['namespace'];

            //获取控制器路径
            $controllerName = ucfirst($act) . 'Controller';
            $controllerFile = $namespaces . '/' . $controllerName . '.php';
            $controllerPath = APP_PATH . '/controllers/' . $controllerFile;
            $controllerNamespace = $namespaces ? '\App\Controllers\\' . $namespaces . '\\' : '\App\Controllers\\';

            //验证controller控制器文件和类是否存在
            if (file_exists($controllerPath) == TRUE && class_exists($controllerNamespace . $controllerName)) {
                self::runController($controllerName, $op, $controllerNamespace);
            }
        }

        //没有找到路由，跳转404错误
        error_404();
    }

    /**
     * 进行方法请求
     *
     * @param string $op 执行方法
     * @param string $namespaces 命名空间
     */
    public static function runController($controllerName, $op, $namespaces) {
        $class = $namespaces . $controllerName;
        //实例化controller
        $controller = new $class();

        //验证方法是否存在
        if (method_exists($controller, $op) == FALSE) {
            error_404();
        }

        //验证通过，执行方法
        $controller->$op();
        exit;
    }

}
