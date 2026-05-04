<?php

/**
 * DocedFrame
 * Router.php
 * Versiyon: 2.0
 * Tarih: 03.05.2026
 */

namespace Core;

class Router
{
	private $routes = [];
	private $notFoundCallback = null;
	
	public function add($method, $route, $callback)
	{
		$route = $this->normalizeRoute($route);
		$this->routes[] = [
			'method' => strtoupper($method),
			'route' => $route,
			'callback' => $callback
		];
	}
	
	public function get($route, $callback)
	{
		$this->add('GET', $route, $callback);
	}
	
	public function post($route, $callback)
	{
		$this->add('POST', $route, $callback);
	}
	
	public function setNotFound($callback)
	{
		$this->notFoundCallback = $callback;
	}
	
	private function normalizeRoute($route)
	{
		if ($route === '/') {
			return '/';
		}
		return '/' . trim($route, '/');
	}
	
	public function dispatch($requestUri, $requestMethod)
	{
		$requestUri = parse_url($requestUri, PHP_URL_PATH);
		
		// ÖNCE admin route'larını kontrol et (admin ile başlayanlar)
		if (strpos($requestUri, '/df-admin') === 0) {
			// Normal route kontrolüne git, permalink parse etme
			$requestUri = $this->normalizeRoute($requestUri);
			$requestMethod = strtoupper($requestMethod);
			
			foreach ($this->routes as $route) {
				if ($route['method'] !== $requestMethod) {
					continue;
				}
				
				$pattern = preg_replace('/:([a-zA-Z0-9_]+)/', '([^/]+)', $route['route']);
				$pattern = '#^' . $pattern . '$#';
				
				if (preg_match($pattern, $requestUri, $matches)) {
					array_shift($matches);
					return $this->executeCallback($route['callback'], $matches);
				}
			}
			
			// Admin route bulunamadıysa 404
			http_response_code(404);
			echo "404 - Sayfa bulunamadı";
			return false;
		}
		
		// Permalink yapısı
		$permalinkStructure = get_option('permalink_structure', '/yazi/%slug%');
		
		// Simple permalink (?p=123)
		if ($permalinkStructure == 'simple' && isset($_GET['p']) && is_numeric($_GET['p'])) {
			return $this->executeCallback('PostController@single', [$_GET['p']]);
		}
		
		// Normal permalink parse
		$slug = $this->parsePermalink($requestUri, $permalinkStructure);
		
		if ($slug !== null) {
			return $this->executeCallback('PostController@single', [$slug]);
		}
		
		// Normal route kontrolü
		$requestUri = $this->normalizeRoute($requestUri);
		$requestMethod = strtoupper($requestMethod);
		
		foreach ($this->routes as $route) {
			if ($route['method'] !== $requestMethod) {
				continue;
			}
			
			$pattern = preg_replace('/:([a-zA-Z0-9_]+)/', '([^/]+)', $route['route']);
			$pattern = '#^' . $pattern . '$#';
			
			if (preg_match($pattern, $requestUri, $matches)) {
				array_shift($matches);
				return $this->executeCallback($route['callback'], $matches);
			}
		}
		
		if ($this->notFoundCallback) {
			return $this->executeCallback($this->notFoundCallback);
		}
		
		http_response_code(404);
		echo "404 - Sayfa bulunamadı";
		return false;
	}
	
	private function parsePermalink($uri, $structure)
	{
		// Yapıdaki etiketleri bul
		preg_match_all('/%([a-z_]+)%/', $structure, $matches);
		$tags = $matches[1];
		
		// Yapıyı regex'e çevir
		$pattern = preg_replace('/%[a-z_]+%/', '([^/]+)', $structure);
		$pattern = '#^' . $pattern . '$#';
		
		if (preg_match($pattern, $uri, $matches)) {
			array_shift($matches);
			
			// slug veya id etiketinin index'ini bul
			$slugIndex = array_search('slug', $tags);
			$idIndex = array_search('id', $tags);
			
			if ($slugIndex !== false && isset($matches[$slugIndex])) {
				return $matches[$slugIndex];
			}
			
			if ($idIndex !== false && isset($matches[$idIndex])) {
				return $matches[$idIndex];
			}
			
			// Son parametre genelde slug'dır
			if (!empty($matches)) {
				return end($matches);
			}
		}
		
		return null;
	}
	
	private function executeCallback($callback, $params = [])
	{
		if (is_callable($callback)) {
			return call_user_func_array($callback, $params);
		}
		
		if (is_string($callback) && strpos($callback, '@') !== false) {
			list($controller, $method) = explode('@', $callback);
			$controllerClass = 'App\\Controllers\\' . $controller;
			
			if (class_exists($controllerClass)) {
				$controllerInstance = new $controllerClass();
				if (method_exists($controllerInstance, $method)) {
					return call_user_func_array([$controllerInstance, $method], $params);
				}
			}
		}
		
		return false;
	}
}