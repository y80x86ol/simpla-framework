<?php

/**
 * 字符串处理类.
 * User: ken
 * Date: 2016/4/3 0003
 * Time: 下午 9:25
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
