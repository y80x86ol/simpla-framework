<?php

/**
 * 请求类.
 * User: ken
 * Date: 2016/4/3 0003
 * Time: 下午 8:42
 */

namespace Illuminate\Http;

use Illuminate\Str\String;

class Request {

    public function __construct() {
        //对get和post参数进行一些过滤和处理
        $_GET = paramFilter($_GET);
        $_POST = paramFilter($_POST);
    }

    /**
     * 获取控制器名字
     *
     * @return mixed
     */
    public static function getController() {
        list($act, $op) = self::getRoute();
        return $act;
    }

    /**
     * 获取方法名字
     *
     * @return mixed
     */
    public static function getAction() {
        list($act, $op) = self::getRoute();
        return $op;
    }

    /**
     * 获取当个get请求
     *
     * @param string $name get键值
     * @param $default 默认值
     * @return bool
     */
    public static function get($name, $default = '') {
        $_GET = self::paramFilter($_GET);
        if (isset($_GET[$name])) {
            if (empty($_GET[$name])) {
                return $default;
            }
            return $_GET[$name];
        }
        return false;
    }

    /**
     * 获取所有get请求参数
     */
    public static function getAll() {
        return self::paramFilter($_GET);
    }

    /**
     * 获取当个post请求
     *
     * @param string $name post键值
     * @param $default 默认值
     * @return bool
     */
    public static function post($name, $default = '') {
        $_POST = self::paramFilter($_POST);
        if (isset($_POST[$name])) {
            if (empty($_POST[$name])) {
                return $default;
            }
            return $_POST[$name];
        }
        return false;
    }

    /**
     * 获取所有post请求参数
     */
    public static function postAll() {
        return self::paramFilter($_POST);
    }

    /**
     * 获取所有请求
     *
     * @return array
     */
    public static function all() {
        $request = array_merge(self::paramFilter($_GET), self::paramFilter($_POST));
        return $request;
    }

    /**
     * 获取请求方式
     *
     * @return string GET POST other
     */
    public static function method() {
        // $this->methodParam 默认值为 '_method'
        // 如果指定 $_POST['_method'] ，表示使用POST请求来模拟其他方法的请求。
        // 此时 $_POST['_method'] 即为所模拟的请求类型。
        if (isset($_POST[$this->methodParam])) {
            return strtoupper($_POST[$this->methodParam]);
            // 或者使用 $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] 的值作为方法名。
        } elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            return strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
            // 或者使用 $_SERVER['REQUEST_METHOD'] 作为方法名，未指定时，默认为 GET 方法
        } else {
            return isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
        }
    }

    /**
     * 获取过滤后的参数
     *
     * @return mixed
     */
    public static function paramFilter($param) {
        if (empty($param)) {
            $param = '';
        }

        if (is_array($param)) {
            foreach ($param as $key => $value) {
                $param[$key] = String::urlSafetyFilter($value);
            }
        }

        if (is_string($param)) {
            $param = String::urlSafetyFilter($param);
        }

        return $param;
    }

    /**
     * 处理路由，获取控制器和执行方法
     *
     * @return array
     */
    public static function getRoute() {
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
            redirect_404();
        }

        //将第一个参数视为控制器，第二个参数视为方法，后面的参数视为参数
        $act = !empty($requestUrlArr[0]) ? $requestUrlArr[0] : 'index';
        $op = isset($requestUrlArr[1]) ? 'action' . ucfirst($requestUrlArr[1]) : 'actionIndex';

        $data = array($act, $op);

        return $data;
    }

}
