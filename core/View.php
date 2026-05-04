<?php

/**
 * DocedFrame
 * View.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core;

class View
{
	public static function render($view, $data = [])
	{
		extract($data);
		
		$viewFile = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';
		
		if (file_exists($viewFile)) {
			require $viewFile;
		} else {
			echo "View bulunamadı: " . $view;
		}
	}
}