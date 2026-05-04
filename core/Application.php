<?php

/**
 * DocedFrame
 * Application.php
 * Versiyon: 1.2
 * Tarih: 03.05.2026
 */

namespace Core;

class Application
{
	private static $instance = null;
	private $config = [];
	private $router;
	
	public function __construct($config = [])
	{
		$this->config = $config;
		$this->registerAutoloader();
		$this->router = new Router();
	}
	
	public static function getInstance($config = [])
	{
		if (self::$instance === null) {
			self::$instance = new self($config);
		}
		return self::$instance;
	}
	
	private function registerAutoloader()
	{
		require_once __DIR__ . '/Autoloader.php';
		
		Autoloader::register();
		Autoloader::addNamespace('Core\\', __DIR__ . '/');
		Autoloader::addNamespace('App\\', __DIR__ . '/../app/');
		Autoloader::loadHelper();
	}
	
	public function getRouter()
	{
		return $this->router;
	}
	
	public function run()
	{
		// Plugin'leri yükle
		\Core\Plugin::loadActivePlugins();
		
		// Plugin route'larını çağır
		$activePlugins = \Core\Plugin::getActivePlugins();
		foreach ($activePlugins as $pluginName) {
			$pluginClass = "Plugin\\" . $pluginName . "\\" . ucfirst($pluginName);
			if (class_exists($pluginClass) && method_exists($pluginClass, 'addRoutes')) {
				$pluginClass::addRoutes();
			}
		}
		
		$requestUri = $_SERVER['REQUEST_URI'];
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		
		$this->router->dispatch($requestUri, $requestMethod);
	}
}