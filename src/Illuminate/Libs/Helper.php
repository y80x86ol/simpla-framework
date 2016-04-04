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
 *404页面跳转
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
		return APP_THEME;
	}
}