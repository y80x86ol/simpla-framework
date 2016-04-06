<?php

/*
 * 系统帮助类
 */

/**
 * 错误展示类
 */
if (!function_exists('error')) {

    function error($msg = '发生了一个未知错误，请检查你的程序') {
        require_once SIMPLA_PATH . '/View/template/error.php';
        die;
    }

}