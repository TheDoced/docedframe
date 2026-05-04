<?php

/**
 * DocedFrame
 * Autoloader.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace Core;

class Autoloader
{
	private static $prefixes = [];
	
	public static function register()
	{
		spl_autoload_register([__CLASS__, 'loadClass']);
	}
	
	public static function addNamespace($prefix, $base_dir)
	{
		$prefix = trim($prefix, '\\') . '\\';
		$base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';
		
		if (!isset(self::$prefixes[$prefix])) {
			self::$prefixes[$prefix] = [];
		}
		
		self::$prefixes[$prefix][] = $base_dir;
	}
	
	public static function loadClass($class)
	{
		$prefix = $class;
		
		while (($pos = strrpos($prefix, '\\')) !== false) {
			$prefix = substr($class, 0, $pos + 1);
			$relative_class = substr($class, $pos + 1);
			
			if (isset(self::$prefixes[$prefix])) {
				foreach (self::$prefixes[$prefix] as $base_dir) {
					$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
					
					if (file_exists($file)) {
						require $file;
						return true;
					}
				}
			}
			
			$prefix = rtrim($prefix, '\\');
		}
		
		return false;
	}
	
	public static function loadHelper()
	{
		$helperFile = __DIR__ . '/Helpers/helpers.php';
		if (file_exists($helperFile)) {
			require $helperFile;
		}
	}
}