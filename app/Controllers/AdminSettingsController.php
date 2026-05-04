<?php

/**
 * DocedFrame
 * AdminSettingsController.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;

class AdminSettingsController extends Controller
{
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_options')) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		View::render('admin.settings.index');
	}
	
	public function update()
	{
		// Genel Ayarlar
		set_option('site_name', $_POST['site_name'] ?? 'DocedFrame');
		set_option('site_description', $_POST['site_description'] ?? '');
		set_option('site_url', $_POST['site_url'] ?? 'http://docedframe.td');
		
		// Admin Ayarları
		set_option('admin_path', $_POST['admin_path'] ?? 'df-admin');
		
		// Yazı Ayarları
		set_option('posts_per_page', $_POST['posts_per_page'] ?? 10);
		set_option('comments_open', $_POST['comments_open'] ?? 1);
		set_option('comment_approval', $_POST['comment_approval'] ?? 1);
		
		$_SESSION['settings_message'] = 'Ayarlar kaydedildi.';
		$this->redirect('/df-admin/settings');
	}
	
	public function permalink()
	{
		View::render('admin.settings.permalink');
	}

	public function updatePermalink()
	{
		$structure = $_POST['permalink_structure'] ?? 'simple';
		
		if ($structure == 'custom') {
			$structure = $_POST['custom_structure'] ?? '/yazi/%slug%';
		}
		
		// Kategori bazlı seçildiyse uyarı kontrolü
		if ($structure == '/%category%/%slug%') {
			$pdo = \Core\Database\Connection::getInstance()->getPdo();
			$stmt = $pdo->query("SELECT COUNT(*) FROM terms WHERE taxonomy = 'category'");
			$categoryCount = $stmt->fetchColumn();
			
			if ($categoryCount == 0) {
				$_SESSION['settings_message'] = 'Uyarı: Kategori bazlı permalink seçtiniz ancak henüz hiç kategori oluşturulmamış. Lütfen önce kategoriler oluşturun.';
				$this->redirect('/df-admin/settings/permalink');
				return;
			}
		}
		
		set_option('permalink_structure', $structure);
		set_option('category_base', $_POST['category_base'] ?? 'kategori');
		set_option('tag_base', $_POST['tag_base'] ?? 'etiket');
		
		$_SESSION['settings_message'] = 'Permalink ayarları kaydedildi.';
		$this->redirect('/df-admin/settings/permalink');
	}
}