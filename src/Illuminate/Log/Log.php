<?php

/*
 * 日志操作类
 */

namespace Illuminate\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log {

    private static function bootstrap($name) {
        $path = LOG_PATH . '/';
        $logName = date('Y-m-d', time()) . '.txt';

        // create a log channel
        $log = new Logger($name);
        $log->pushHandler(new StreamHandler($path . $logName));
        $log->pushHandler(new FirePHPHandler());
        return $log;
    }

    public static function emergency($msg) {
        $log = self::bootstrap('simpla');
        $log->addEmergency($msg);
    }

    public static function alert($msg) {
        $log = self::bootstrap('simpla');
        $log->addAlert($msg);
    }

    public static function critical($msg) {
        $log = self::bootstrap('simpla');
        $log->addCritical($msg);
    }

    public static function error($msg) {
        $log = self::bootstrap('simpla');
        $log->addError($msg);
    }

    public static function warning($msg) {
        $log = self::bootstrap('simpla');
        $log->addWarning($msg);
    }

    public static function notice($msg) {
        $log = self::bootstrap('simpla');
        $log->addNotice($msg);
    }

    public static function info($msg) {
        $log = self::bootstrap('simpla');
        $log->addInfo($msg);
    }

    public static function debug($msg) {
        $log = self::bootstrap('simpla');
        $log->addDebug($msg);
    }

}
