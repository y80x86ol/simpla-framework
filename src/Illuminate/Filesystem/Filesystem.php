<?php

/**
 * 文件处理类.
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

    /**
     * 遍历一个文件夹下面的文件夹
     * @param string $dirPath 需要进行遍历的文件夹
     * @return array
     */
    public static function getDirList($dirPath) {
        $dirList = array();
        if (is_dir($dirPath)) {
            if ($dh = opendir($dirPath)) {
                while (($file = readdir($dh)) !== false) {
                    if ((is_dir($dirPath . $file)) && $file != "." && $file != "..") {
                        $dirList[] = $file;
                    } else {
                        continue;
                    }
                }
                closedir($dh);
            }
        } else {
            error("该路径不是一个文件夹");
        }

        return $dirList;
    }

}
