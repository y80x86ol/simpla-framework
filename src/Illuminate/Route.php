<?php

/*
 * 路由
 */

namespace Illuminate;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class Route {

    /**
     * 路由检查
     */
    public static function check() {
        //获取控制器和方法
        list($act, $op) = Request::getRoute();

        //获取控制器路径
        $controllerName = ucfirst($act) . 'Controller';
        $controllerFile = $controllerName . '.php';
        $controllerPath = APP_PATH . '/controllers/' . $controllerFile;
        $namespaces = '\App\Controllers\\' . $controllerName;

        //获取系统控制器路径
        $systemControllerName = ucfirst($act) . 'Controller';
        $systemControllerFile = $systemControllerName . '.php';
        $systemControllerPath = SIMPLA_PATH . '/Http/' . $systemControllerFile;
        $systemNamespaces = '\Illuminate\Http\\' . $systemControllerName;

        //验证主文件夹下控制器是否存在
        if (file_exists($controllerPath) == TRUE) {
            self::runController($op, $namespaces);
        } elseif (file_exists($systemControllerPath) == TRUE && in_array($systemControllerName, array('HandlerController'))) {
            self::runController($op, $systemNamespaces);
        }

        //验证主文件夹下面的子文件夹是否存在该控制器方法
        $dirList = Filesystem::getDirList(APP_PATH . '/controllers/');
        if ($dirList) {
            foreach ($dirList as $item) {
                $controllerPath = APP_PATH . '/controllers/' . $item . '/' . $controllerFile;
                if (file_exists($controllerPath) == TRUE) {
                    $namespaces = '\App\Controllers\\' . $item . '\\' . $controllerName;
                    self::runController($op, $namespaces);
                }
            }
        }

        //没有找到路由，跳转404错误
        redirect_404();
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
            redirect_404();
        }

        //验证通过，执行方法
        $controller->$op();
        exit;
    }

}
