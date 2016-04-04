<?php
/**
 * 响应类.
 * User: ken
 * Date: 2016/4/3 0003
 * Time: 下午 8:42
 */

namespace Illuminate\Http;


class Response {

	/**
	 * 输出json格式
	 *
	 * @param $data
	 * @return json
	 */
	public static function json($data) {
		return json_encode($data);
	}
}