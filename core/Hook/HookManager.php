<?php

/**
 * DocedFrame
 * HookManager.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core\Hook;

class HookManager
{
	private static $actions = [];
	private static $filters = [];
	
	public static function addAction($hook, $callback, $priority = 10)
	{
		if (!isset(self::$actions[$hook])) {
			self::$actions[$hook] = [];
		}
		if (!isset(self::$actions[$hook][$priority])) {
			self::$actions[$hook][$priority] = [];
		}
		self::$actions[$hook][$priority][] = $callback;
	}
	
	public static function doAction($hook, ...$args)
	{
		if (!isset(self::$actions[$hook])) {
			return;
		}
		
		ksort(self::$actions[$hook]);
		
		foreach (self::$actions[$hook] as $priority => $callbacks) {
			foreach ($callbacks as $callback) {
				call_user_func_array($callback, $args);
			}
		}
	}
	
	public static function addFilter($hook, $callback, $priority = 10)
	{
		if (!isset(self::$filters[$hook])) {
			self::$filters[$hook] = [];
		}
		if (!isset(self::$filters[$hook][$priority])) {
			self::$filters[$hook][$priority] = [];
		}
		self::$filters[$hook][$priority][] = $callback;
	}
	
	public static function applyFilters($hook, $value, ...$args)
	{
		if (!isset(self::$filters[$hook])) {
			return $value;
		}
		
		ksort(self::$filters[$hook]);
		
		foreach (self::$filters[$hook] as $priority => $callbacks) {
			foreach ($callbacks as $callback) {
				array_unshift($args, $value);
				$value = call_user_func_array($callback, $args);
			}
		}
		
		return $value;
	}
}