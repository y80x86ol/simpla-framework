<?php

/*
 * 系统帮助支持类
 */

use Illuminate\Log\Log;

/**
 * 错误展示类
 */
if (!function_exists('error')) {

    function error($msg = '发生了一个未知错误，请检查你的程序') {
        require_once SIMPLA_PATH . '/View/template/error.php';
        die;
    }

}

/**
 * 404错误展示类
 */
if (!function_exists('error_404')) {

    function error_404() {

        //404错误进行日志记录
        $msg = '404 not found，method：' . filter_input(INPUT_SERVER, 'REQUEST_METHOD') . '，url：' . filter_input(INPUT_SERVER, 'REQUEST_URI') . '，Http Status：' . filter_input(INPUT_SERVER, 'REDIRECT_STATUS');
        Log::error($msg);

        error("404 not found");
    }

}

/**
 * 应用名字
 */
if (!function_exists('appName')) {

    function app_name() {
        return APP_NAME;
    }

}

/**
 * 应用主题
 */
if (!function_exists('theme')) {

    function theme() {
        return '/' . trim(APP_THEME, '/');
    }

}

/**
 * 应用域名地址
 */
if (!function_exists('base_url')) {

    function base_url() {
        return '/' . trim(BASE_URL, '/');
    }

}

/**
 * 上传的文件地址
 */
if (!function_exists('storage')) {

    function storage() {
        return '/' . ltrim(APP_STORAGE, '/');
    }

}

/**
 * 环境判断
 */
if (!function_exists('env')) {

    function env($key, $default = null) {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        return $value;
    }

}