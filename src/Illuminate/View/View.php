<?php

/**
 * 视图.
 * User: ken<695093513@qq.com>
 * Date: 2016/3/26 0026
 * Time: 下午 9:30
 */

namespace Illuminate\View;

use Illuminate\Config\Config;
use League\Plates\Engine;

class View {

    /**
     * 获取plates模板引擎
     * @return Engine
     */
    public static function getTemplate() {
        return new Engine(self::getViewPath());
    }

    /**
     * 获取视图所在文件夹
     * @return string
     */
    public static function getViewPath() {
        $appConfig = Config::get('app');
        if (empty($appConfig['theme'])) {
            $viewPath = APP_PATH . '/views';
        } else {
            $viewPath = APP_PATH . '/views/' . $appConfig['theme'];
        }
        return $viewPath;
    }

}
