<?php

/**
 * DocedFrame
 * HomeController.php
 * Versiyon: 1.3
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\Theme;
use App\Models\Post;

class HomeController extends Controller
{
	public function index()
	{
		$postModel = new Post();
		$posts = $postModel->getPublished();
		
		Theme::render('index', ['posts' => $posts]);
	}
	
	public function about()
	{
		echo "Hakkımızda sayfası";
	}
}