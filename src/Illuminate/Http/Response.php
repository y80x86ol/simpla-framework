<?php

/**
 * 响应类.
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
