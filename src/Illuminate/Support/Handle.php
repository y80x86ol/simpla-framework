<?php

/*
 * 系统帮助类
 */

/**
 * 错误展示类
 */
if (!function_exists('error')) {

    function error($msg = '发生了一个未知错误，请检查你的程序') {
        $html = <<<EOF
            <h3>Simpla
                </h3
            <p>
                $msg
            </p>
EOF;
        echo $html;
        die;
    }

}