<?php

/**
 * DocedFrame
 * PostController.php
 * Versiyon: 2.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\Theme;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
	public function index()
	{
		$postModel = new Post();
		$posts = $postModel->getPublished();
		
		Theme::render('index', ['posts' => $posts]);
	}
	
	public function single($slug = null)
	{
		$postModel = new Post();
		$pdo = $postModel->getPdo();
		
		// ID ile gelmişse (?p=123)
		if (is_numeric($slug)) {
			$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id AND status = 'publish'");
			$stmt->execute(['id' => $slug]);
		} else {
			// Slug ile gelmişse
			$stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'publish'");
			$stmt->execute(['slug' => $slug]);
		}
		
		$post = $stmt->fetch();
		
		if (!$post) {
			$this->showNotFoundMessage($slug);
			return;
		}
		
		$commentModel = new Comment();
		$comments = $commentModel->getApprovedByPost($post['id']);
		
		Theme::render('single', [
			'post' => $post,
			'comments' => $comments
		]);
	}
	
	private function showNotFoundMessage($slug)
	{
		$html = '<!DOCTYPE html>';
		$html .= '<html><head><title>Yazı Bulunamadı</title>';
		$html .= '<style>';
		$html .= 'body { font-family: Arial; text-align: center; padding: 50px; background: #f4f4f4; }';
		$html .= '.message { background: #fff; padding: 30px; border-radius: 5px; max-width: 500px; margin: 0 auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }';
		$html .= 'h1 { color: #d9534f; }';
		$html .= '.btn { display: inline-block; background: #0073aa; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 20px; }';
		$html .= '</style>';
		$html .= '</head><body>';
		$html .= '<div class="message">';
		$html .= '<h1>⚠️ Yazı Bulunamadı</h1>';
		$html .= '<p><strong>Aradığınız URL:</strong> ' . htmlspecialchars($_SERVER['REQUEST_URI']) . '</p>';
		$html .= '<p><strong>Permalink yapınız:</strong> ' . htmlspecialchars(get_option('permalink_structure', '/yazi/%slug%')) . '</p>';
		
		if ($slug && !is_numeric($slug)) {
			$html .= '<p><strong>Aranan slug:</strong> ' . htmlspecialchars($slug) . '</p>';
			$html .= '<p>Bu slug ile eşleşen bir yazı bulunamadı.</p>';
		}
		
		$html .= '<a href="/" class="btn">← Ana Sayfaya Dön</a>';
		$html .= '</div>';
		$html .= '</body></html>';
		
		echo $html;
	}
	
	public function addComment()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->redirect('/');
		}
		
		$postId = $_POST['post_id'] ?? 0;
		$authorName = $_POST['author_name'] ?? '';
		$authorEmail = $_POST['author_email'] ?? '';
		$content = $_POST['content'] ?? '';
		$postSlug = $_POST['post_slug'] ?? '';
		
		$commentModel = new Comment();
		$commentModel->insert([
			'post_id' => $postId,
			'author_name' => $authorName,
			'author_email' => $authorEmail,
			'content' => $content,
			'status' => 'pending'
		]);
		
		$this->redirect('/yazi/' . $postSlug);
	}
}