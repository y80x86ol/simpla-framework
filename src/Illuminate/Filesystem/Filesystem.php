<?php

/**
 * 文件处理类.
 * User: Administrator
 * Date: 2016/4/2 0002
 * Time: 下午 10:12
 */

namespace Illuminate\Filesystem;

class Filesystem {

    /**
     * 创建文件夹
     *
     * @param string $filePath 文件夹路径
     * @param int $mode 文件夹权限
     * @return bool
     */
    public static function mkdir($filePath, $mode = 0777) {
        if (empty($filePath)) {
            return false;
        }
        if (!file_exists($filePath)) {
            mkdir($filePath, $mode);
        }
        return true;
    }

}
