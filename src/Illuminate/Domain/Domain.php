<?php

/*
 * 域名类
 */

namespace Illuminate\Domain;

use Illuminate\Config\Config;

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

    /**
     * 验证二级域名是否设置
     * @return boolean|string
     */
    public static function checkSecondDomain() {
        $domain = self::getSecondDomain();
        $domainConfig = Config::get('app.domain');
        if (isset($domainConfig[$domain])) {
            return $domainConfig[$domain];
        }
        return false;
    }

}
