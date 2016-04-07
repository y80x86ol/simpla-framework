<?php

/*
 * 模块类
 */

namespace Illuminate\Http;

use Illuminate\Database\Database;

class Model {

    private $_instance;
    protected $table;

    public function __construct() {
        //ToDo
    }

    /**
     * 数据库查询
     *
     * @param string $sql
     */
    public function getQuery($sql) {
        return Database::getQuery($sql);
    }

    /**
     * where条件组装
     *
     * @param array $array
     * @return \mysql
     */
    public function where($array) {
        $where = "";
        foreach ($array as $key => $value) {
            $value = Database::$sqlServer->real_escape_string($value);
            if ($where == "") {
                if (is_array($value)) {
                    $where .= "";
                } else {
                    $where .= "where " . $key . "='" . $value . "'";
                }
            } else {
                if (is_array($value)) {
                    $where .= "";
                } else {
                    $where .= "and " . $key . "=" . $value;
                }
            }
        }
        $this->_instance['where'] = $where;
        return $this;
    }

    /**
     * 查询条件限制
     *
     * @param string $limit
     * @return obj
     */
    public function limit($limit) {
        $this->_instance['limit'] = ' limit ' . $limit;
        return $this;
    }

    /**
     * 数据库名字
     *
     * @param string $table
     * @return obj
     */
    public function table($table) {
        $this->_instance['table'] = $table . ' ';
        return $this;
    }

    /**
     * 需要查询的字段
     *
     * @param string $fileds
     * @return obj
     */
    public function fields($fileds) {
        $this->_instance['fields'] = 'select ' . $fileds . ' ';
        return $this;
    }

    /**
     * 排序方式
     *
     * @param string $order
     * @return obj
     */
    public function orderBy($order) {
        $this->_instance['order'] = 'order by ' . $order . ' ';
        return $this;
    }

    /**
     * 分组条件
     *
     * @param string $group
     * @return obj
     */
    public function groupBy($group) {
        $this->_instance['group'] = 'group by ' . $group . ' ';
        return $this;
    }

    /**
     * 查询所有结果
     *
     * @return mixed
     */
    public function select() {
        $sql = $this->getSql();

        return Database::getQueryAll($sql);
    }

    /**
     * 查询单条记录
     *
     * @return mixed
     */
    public function findOne() {
        $sql = $this->getSql();

        return Database::getQueryOne($sql);
    }

    /**
     * 查询总数
     *
     * @return array
     */
    public function count() {
        $sql = $this->getSql();
        return Database::getQueryOne($sql);
    }

    /**
     * 获取组装后的sql语句
     *
     * @return string
     */
    private function getSql() {
        $sql = '';

        if (isset($this->_instance['fields'])) {
            $sql .= $this->_instance['fields'];
        } else {
            $sql .= 'select * ';
        }
        if (isset($this->_instance['table'])) {
            $sql .= ' from ' . $this->_instance['table'];
        } else {
            die('不存在的表名');
        }

        if (isset($this->_instance['where'])) {
            $sql .= $this->_instance['where'];
        }
        if (isset($this->_instance['limit'])) {
            $sql .= $this->_instance['limit'];
        }
        if (isset($this->_instance['order'])) {
            $sql .= $this->_instance['order'];
        }
        if (isset($this->_instance['group'])) {
            $sql .= $this->_instance['group'];
        }

        return $sql;
    }

    /**
     * --------------------------------------------------------------
     * 插入操作
     * --------------------------------------------------------------
     */

    /**
     * 插入数据
     *
     * @param $data
     */
    public function insert($data) {
        $sql = 'insert into ';
        if (isset($this->_instance['table'])) {
            $sql .= $this->_instance['table'];
        } else {
            die('不存在的数据表');
        }
        $data_key = '(';
        $data_value = '';
        foreach ($data as $key => $value) {
            $data_key .= $key . ',';
            $data_value .= $value . ',';
        }

        $data_key = rtrim($data_key, ',') . ')';
        $data_value = rtrim($data_value, ',') . ')';

        $sql .= $data_key . ' values ' . $data_value;

        $this->getQuery($sql);
    }

    /**
     * --------------------------------------------------------------
     * 其他
     * --------------------------------------------------------------
     */

    /**
     * 获取查询的表名字
     *
     * @return mixed
     */
    private function getTable() {
        if (isset($this->_instance['table'])) {
            return $this->_instance['table'];
        } elseif (!empty($this->table)) {
            return $this->table;
        } else {
            die('不存在的表名');
        }
    }

}
