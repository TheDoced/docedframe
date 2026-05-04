<?php

/**
 * DocedFrame
 * Theme.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core;

use App\Models\Option;

class Theme
{
	public static function getActiveTheme()
	{
		return get_option('active_theme', 'default');
	}
	
	public static function setActiveTheme($themeName)
	{
		set_option('active_theme', $themeName);
	}
	
	public static function getThemePath()
	{
		$theme = self::getActiveTheme();
		return __DIR__ . '/../themes/' . $theme . '/';
	}
	
	public static function getThemeUrl()
	{
		$theme = self::getActiveTheme();
		return '/themes/' . $theme . '/';
	}
	
	public static function render($template, $data = [])
	{
		extract($data);
		$templateFile = self::getThemePath() . $template . '.php';
		
		if (file_exists($templateFile)) {
			require $templateFile;
		} else {
			echo "Tema dosyası bulunamadı: " . $template;
		}
	}
	
	public static function getAvailableThemes()
	{
		$themesDir = __DIR__ . '/../themes/';
		$themes = [];
		
		if (is_dir($themesDir)) {
			$dirs = scandir($themesDir);
			foreach ($dirs as $dir) {
				if ($dir !== '.' && $dir !== '..' && is_dir($themesDir . $dir)) {
					$themeFile = $themesDir . $dir . '/theme.json';
					if (file_exists($themeFile)) {
						$info = json_decode(file_get_contents($themeFile), true);
						$themes[] = [
							'name' => $dir,
							'title' => $info['title'] ?? $dir,
							'description' => $info['description'] ?? '',
							'version' => $info['version'] ?? '1.0'
						];
					}
				}
			}
		}
		
		return $themes;
	}
}