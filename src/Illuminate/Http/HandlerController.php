<?php
/**
 * 系统自带处理控制器.
 * User: ken
 * Date: 2016/3/27 0027
 * Time: 下午 10:18
 */

namespace Illuminate\Http;

use Illuminate\Http\Controller;

class HandlerController extends Controller {

	/**
	 * 404 not found
	 */
	public function action404() {
		echo '<p>404 not found</p>';
		die;
	}
}