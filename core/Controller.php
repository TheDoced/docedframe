<?php

/**
 * DocedFrame
 * Controller.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core;

class Controller
{
	protected function view($view, $data = [])
	{
		extract($data);
		
		$viewFile = __DIR__ . '/../app/Views/' . str_replace('.', '/', $view) . '.php';
		
		if (file_exists($viewFile)) {
			require $viewFile;
		} else {
			echo "View bulunamadı: " . $view;
		}
	}
	
	protected function json($data, $statusCode = 200)
	{
		http_response_code($statusCode);
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}
	
	protected function redirect($url)
	{
		header('Location: ' . $url);
		exit;
	}
}