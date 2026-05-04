<?php

/**
 * DocedFrame
 * SearchController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\Theme;
use App\Models\Post;

class SearchController extends Controller
{
	public function index()
	{
		$keyword = $_GET['s'] ?? '';
		$keyword = trim($keyword);
		
		$results = [];
		
		if (!empty($keyword)) {
			$results = $this->searchPosts($keyword);
		}
		
		Theme::render('search', [
			'keyword' => $keyword,
			'results' => $results
		]);
	}
	
	private function searchPosts($keyword)
	{
		$postModel = new Post();
		$pdo = $postModel->getPdo();
		
		$searchTerm = '%' . $keyword . '%';
		
		$stmt = $pdo->prepare("
			SELECT * FROM posts 
			WHERE (title LIKE :term OR content LIKE :term) 
			AND status = 'publish'
			ORDER BY created_at DESC
		");
		$stmt->execute(['term' => $searchTerm]);
		
		return $stmt->fetchAll();
	}
	
	public function ajaxSearch()
	{
		$keyword = $_GET['q'] ?? '';
		$keyword = trim($keyword);
		
		$results = [];
		
		if (!empty($keyword) && strlen($keyword) >= 2) {
			$postModel = new Post();
			$pdo = $postModel->getPdo();
			
			$searchTerm = '%' . $keyword . '%';
			
			$stmt = $pdo->prepare("
				SELECT id, title, slug, excerpt 
				FROM posts 
				WHERE (title LIKE :term OR content LIKE :term) 
				AND status = 'publish'
				LIMIT 10
			");
			$stmt->execute(['term' => $searchTerm]);
			$results = $stmt->fetchAll();
		}
		
		header('Content-Type: application/json');
		echo json_encode($results);
		exit;
	}
}