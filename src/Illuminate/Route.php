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
        list($act, $op, $namespace) = Request::getRoute();

        //获取控制器路径
        $controllerName = ucfirst($act) . 'Controller';
        $controllerFile = ($namespace ? $namespace . '/' : '') . $controllerName . '.php';
        $controllerPath = APP_PATH . '/controllers/' . $controllerFile;
        $namespaces = '\App\Controllers\\' . ($namespace ? $namespace . '\\' : '') . $controllerName;

        //验证controller文件夹下控制器是否存在
        if (file_exists($controllerPath) == TRUE) {
            self::runController($op, $namespaces);
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
    public static function runController($op, $namespaces) {
        //实例化controller
        $controller = new $namespaces();

        //验证方法是否存在
        if (method_exists($controller, $op) == FALSE) {
            error_404();
        }

        //验证通过，执行方法
        $controller->$op();
        exit;
    }

}
