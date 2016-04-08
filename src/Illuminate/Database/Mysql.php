<?php

/**
 * Mysql连接操作类.
 * User: ken
 * Date: 2016/4/4 0004
 * Time: 下午 3:30
 */

namespace Illuminate\Database;

use mysqli;

class Mysql {

    private $config;

    public function connect($config) {
        $this->config = $config;
        $mysqli = new mysqli($this->config['host'], $this->config['username'], $this->config['password'], $this->config['database']);
        if ($mysqli->connect_errno) {
            $msg = "连接数据库失败: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            echo $msg;
            exit;
        }
        return $mysqli;
    }

}
