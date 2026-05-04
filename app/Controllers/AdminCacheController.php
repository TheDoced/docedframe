<?php

/**
 * DocedFrame
 * AdminCacheController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;

class AdminCacheController extends Controller
{
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_options')) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		View::render('admin.cache.index');
	}
	
	public function clear()
	{
		cache_clear();
		$_SESSION['cache_message'] = 'Cache başarıyla temizlendi.';
		$this->redirect('/df-admin/cache');
	}
}