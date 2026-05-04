<?php

/**
 * DocedFrame
 * AdminThemeController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use Core\Theme;

class AdminThemeController extends Controller
{
	public function __construct()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		$activeTheme = Theme::getActiveTheme();
		$themes = Theme::getAvailableThemes();
		
		View::render('admin.themes.index', [
			'themes' => $themes,
			'activeTheme' => $activeTheme
		]);
	}
	
	public function activate($themeName)
	{
		Theme::setActiveTheme($themeName);
		$this->redirect('/df-admin/themes');
	}
}