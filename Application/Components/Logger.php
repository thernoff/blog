<?php

namespace Application\Components;

use Application\Core\Config;

class Logger {

    protected static $logger = null;
    protected static $pathLogs = '';

    public function __construct() {
        if (null !== self::$logger) {
            return self::$logger;
        }

        $config = Config::instance()->data;
        $dirLog = (isset($config['settings_logs']['dir_log'])) ? $config['settings_logs']['dir_log'] : 'logs';
        $fileLog = (isset($config['settings_logs']['file_log'])) ? $config['settings_logs']['file_log'] : 'log.txt';

        if (!@is_dir($dirLog)) {
            mkdir($dirLog, 0755, true);
        }

        self::$pathLogs = $dirLog . "/" . $fileLog;
    }

    public static function addError($error) {
        self::$logger = new self();

        $file = file_get_contents(self::$logger->getPathLogs());
        $file .= $error . "\n";
        file_put_contents(self::$logger->getPathLogs(), $file);
    }

    protected function getPathLogs() {
        return self::$pathLogs;
    }

}
