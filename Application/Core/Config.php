<?php

namespace Application\Core;

class Config
{
	protected static $instance;
	public $data;
	
	protected function __construct()
	{
		//$this->data = require('../config/config.php');
		$this->data = require __DIR__.'/../config/config.php';
	}
	
	public static function instance()
	{
		if (null == static::$instance){
			static::$instance = new static;
		}
		
		return static::$instance;
	}
}