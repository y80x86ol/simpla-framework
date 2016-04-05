<?php

/**
 * 视图.
 * User: ken<695093513@qq.com>
 * Date: 2016/3/26 0026
 * Time: 下午 9:30
 */

namespace Illuminate\View;

use Illuminate\Config\Config;

class View {
	/**
	 * 输出视图文件
	 *
	 * @param string $viewName 视图文件
	 * @param array $data 视图参数
	 */
	public static function make($viewName, $data = array()) {
		$viewPath = self::getViewPath($viewName);

		if (file_exists($viewPath)) {
                        //输出参数
                        foreach($data as $key => $value) {
                            $$key = $value;
                        }
                        //引入模板文件
			require $viewPath;
		} else {
			die('不存在的模板文件');
		}
	}

	/**
	 * 获取视图文件路径
	 *
	 * @param string $viewName 视图文件名字
	 * @return string 视图路径
	 */
	public static function getViewPath($viewName) {
		$appConfig = Config::get('app');
		if (empty($appConfig['theme'])) {
			$viewPath = APP_PATH . '/views/' . $viewName . '.php';
		} else {
			$viewPath = APP_PATH . '/views/' . $appConfig['theme'] . '/' . $viewName . '.php';
		}
		return $viewPath;
	}
}
