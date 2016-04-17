<?php

/**
 * 字符串处理类.
 */

namespace Illuminate\Str;

class String {

    /**
     * 字符串安全过滤
     */
    public static function urlSafetyFilter($string) {
        //剥去字符串中的 HTML 和 PHP 标签
        $string = strip_tags($string);
        $string = trim($string, ' ');
        $string = htmlentities($string);

        return $string;
    }

}
