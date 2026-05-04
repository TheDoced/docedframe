<?php

/**
 * DocedFrame
 * Plugin.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core;

use App\Models\Option;

class Plugin
{
	private static $plugins = [];
	
	public static function register($pluginName, $pluginFile)
	{
		self::$plugins[$pluginName] = $pluginFile;
	}
	
	public static function activate($pluginName)
	{
		$activePlugins = self::getActivePlugins();
		
		if (!in_array($pluginName, $activePlugins)) {
			$activePlugins[] = $pluginName;
			self::saveActivePlugins($activePlugins);
			
			if (method_exists($pluginName, 'activate')) {
				$pluginName::activate();
			}
			
			return true;
		}
		
		return false;
	}
	
	public static function deactivate($pluginName)
	{
		$activePlugins = self::getActivePlugins();
		
		$key = array_search($pluginName, $activePlugins);
		if ($key !== false) {
			unset($activePlugins[$key]);
			self::saveActivePlugins(array_values($activePlugins));
			
			if (method_exists($pluginName, 'deactivate')) {
				$pluginName::deactivate();
			}
			
			return true;
		}
		
		return false;
	}
	
	public static function getActivePlugins()
	{
		$active = get_option('active_plugins', '');
		if (empty($active)) {
			return [];
		}
		return explode(',', $active);
	}
	
	private static function saveActivePlugins($plugins)
	{
		set_option('active_plugins', implode(',', $plugins));
	}
	
	public static function loadActivePlugins()
	{
		$activePlugins = self::getActivePlugins();
		
		foreach ($activePlugins as $pluginName) {
			$pluginFile = __DIR__ . '/../plugins/' . $pluginName . '/plugin.php';
			if (file_exists($pluginFile)) {
				require_once $pluginFile;
				
				$pluginClass = "Plugin\\" . $pluginName . "\\" . $pluginName;
				if (class_exists($pluginClass) && method_exists($pluginClass, 'boot')) {
					$pluginClass::boot();
				}
			}
		}
	}
	
	public static function getAllPlugins()
	{
		$pluginsDir = __DIR__ . '/../plugins/';
		$plugins = [];
		
		if (is_dir($pluginsDir)) {
			$dirs = scandir($pluginsDir);
			foreach ($dirs as $dir) {
				if ($dir !== '.' && $dir !== '..' && is_dir($pluginsDir . $dir)) {
					$pluginFile = $pluginsDir . $dir . '/plugin.php';
					if (file_exists($pluginFile)) {
						$pluginInfo = self::getPluginInfo($pluginFile);
						$plugins[] = [
							'name' => $dir,
							'title' => $pluginInfo['title'] ?? $dir,
							'description' => $pluginInfo['description'] ?? '',
							'version' => $pluginInfo['version'] ?? '1.0',
							'author' => $pluginInfo['author'] ?? 'DocedFrame'
						];
					}
				}
			}
		}
		
		return $plugins;
	}
	
	private static function getPluginInfo($pluginFile)
	{
		$content = file_get_contents($pluginFile);
		$info = [];
		
		if (preg_match('/\* Plugin Name:\s*(.+)/i', $content, $match)) {
			$info['title'] = trim($match[1]);
		}
		if (preg_match('/\* Description:\s*(.+)/i', $content, $match)) {
			$info['description'] = trim($match[1]);
		}
		if (preg_match('/\* Version:\s*(.+)/i', $content, $match)) {
			$info['version'] = trim($match[1]);
		}
		if (preg_match('/\* Author:\s*(.+)/i', $content, $match)) {
			$info['author'] = trim($match[1]);
		}
		
		return $info;
	}
}