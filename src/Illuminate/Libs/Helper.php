<?php

/**
 * Created by PhpStorm.
 * User: ken
 * Date: 2016/3/25 0025
 * Time: 下午 11:10
 */
/**
 * 重定向
 */
if (!function_exists('redirect')) {

    function redirect($url) {
        header('Location: ' . $url);
    }

}

/**
 * 404页面跳转
 */
if (!function_exists('redirect_404')) {

    function redirect_404() {
        $url = '/handler/404';
        redirect($url);
    }

}

/**
 * debug调试
 */
if (!function_exists('dd')) {

    function dd() {
        $data = func_get_args();
        foreach ($data as $item) {
            print_r($item);
        }
        die('Test');
    }

}