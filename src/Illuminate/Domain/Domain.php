<?php

/*
 * 域名操作类
 */

namespace Illuminate\Domain;

class Domain {

    /**
     * 获取二级域名名称
     * @return string
     */
    public static function getSecondDomain() {
        $serverName = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $serverArr = explode('.', $serverName);
        $domain = array_shift($serverArr);

        return $domain;
    }

}
