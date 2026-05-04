<?php

/**
 * DocedFrame
 * AdminController.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;

class AdminController extends Controller
{
	public function login()
	{
		if (Auth::check()) {
			$this->redirect('/df-admin/dashboard');
		}
		View::render('admin.login');
	}
	
	public function doLogin()
	{
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		
		if (Auth::attempt($email, $password)) {
			$this->redirect('/df-admin/dashboard');
		} else {
			echo "Hatalı e-posta veya şifre. <a href='/df-admin'>Geri dön</a>";
		}
	}
	
	public function dashboard()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
		
		$pdo = \Core\Database\Connection::getInstance()->getPdo();
		
		// Toplam yazı
		$stmt = $pdo->query("SELECT COUNT(*) FROM posts WHERE type = 'post' AND status = 'publish'");
		$totalPosts = $stmt->fetchColumn();
		
		// Toplam sayfa
		$stmt = $pdo->query("SELECT COUNT(*) FROM posts WHERE type = 'page' AND status = 'publish'");
		$totalPages = $stmt->fetchColumn();
		
		// Toplam kullanıcı
		$stmt = $pdo->query("SELECT COUNT(*) FROM users");
		$totalUsers = $stmt->fetchColumn();
		
		// Toplam yorum
		$stmt = $pdo->query("SELECT COUNT(*) FROM comments");
		$totalComments = $stmt->fetchColumn();
		
		View::render('admin.dashboard', [
			'totalPosts' => $totalPosts,
			'totalPages' => $totalPages,
			'totalUsers' => $totalUsers,
			'totalComments' => $totalComments
		]);
	}

	public function logout()
	{
		Auth::logout();
		$this->redirect('/df-admin');
	}
}