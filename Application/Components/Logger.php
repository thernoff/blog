<?php

namespace Application\Components;

class Logger{
	protected static $fileName = 'Application/logs/log.txt';
	protected static $log;
	
	public function __construct()
	{
		//self::$log = fopen($this->fileName, 'a');
	}
	
	public static function addError($error)
	{
		$res = file_get_contents(self::$fileName);
		//$res[] = $error;
		$res .= $error . "\n";
		//file_put_contents(self::$fileName, implode("\n", $res));
		file_put_contents(self::$fileName, $res);
	}
}