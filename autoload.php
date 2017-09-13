<?php
/**
 * @param unknown $class
 */
function __autoload($class)
{
	
	if (file_exists(__DIR__ . '/' . str_replace('\\', '/', $class) . '.php')){
		require __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';		
	}
}