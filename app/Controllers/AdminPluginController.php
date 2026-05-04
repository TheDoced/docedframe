<?php

/**
 * DocedFrame
 * AdminPluginController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use Core\Plugin;

class AdminPluginController extends Controller
{
	public function __construct()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		$activePlugins = Plugin::getActivePlugins();
		$plugins = Plugin::getAllPlugins();
		
		View::render('admin.plugins.index', [
			'plugins' => $plugins,
			'activePlugins' => $activePlugins
		]);
	}
	
	public function activate($pluginName)
	{
		Plugin::activate($pluginName);
		
		// Eklentinin activate() metodunu çağır
		$pluginClass = "Plugin\\" . $pluginName . "\\" . ucfirst($pluginName);
		if (class_exists($pluginClass) && method_exists($pluginClass, 'activate')) {
			$pluginClass::activate();
		}
		
		$this->redirect('/df-admin/plugins');
	}

	public function deactivate($pluginName)
	{
		Plugin::deactivate($pluginName);
		
		// Eklentinin deactivate() metodunu çağır
		$pluginClass = "Plugin\\" . $pluginName . "\\" . ucfirst($pluginName);
		if (class_exists($pluginClass) && method_exists($pluginClass, 'deactivate')) {
			$pluginClass::deactivate();
		}
		
		$this->redirect('/df-admin/plugins');
	}
}