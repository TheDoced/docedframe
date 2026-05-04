<?php

/**
 * DocedFrame
 * UserController.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\User;

class UserController extends Controller
{
	public function index()
	{
		$userModel = new User();
		$users = $userModel->all();
		
		View::render('users.index', ['users' => $users]);
	}
}