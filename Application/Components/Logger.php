<?php

namespace Application\Components;

use Application\Core\Config;

class Logger {

    protected static $logger = null;
    protected static $pathLogs = '';
    protected static $log;

    public function __construct() {
        if (null !== self::$logger) {
            return self::$logger;
        }

        $config = Config::instance()->data;
        $dirLog = $config['settings_logs']['dir_log'];
        $fileLog = $config['settings_logs']['file_log'];

        if (!@is_dir($dirLog)) {
            mkdir($dirLog, 0770, true);
        }

        self::$pathLogs = $dirLog . "/" . $fileLog;
        self::$log = fopen(self::$pathLogs, 'a');
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
