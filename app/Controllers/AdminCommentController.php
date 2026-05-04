<?php

/**
 * DocedFrame
 * AdminCommentController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Comment;

class AdminCommentController extends Controller
{
	public function __construct()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		$commentModel = new Comment();
		$pdo = $commentModel->getPdo();
		
		$stmt = $pdo->prepare("
			SELECT c.*, p.title as post_title 
			FROM comments c 
			LEFT JOIN posts p ON c.post_id = p.id 
			ORDER BY c.created_at DESC
		");
		$stmt->execute();
		$comments = $stmt->fetchAll();
		
		View::render('admin.comments.index', ['comments' => $comments]);
	}
	
	public function approve($id)
	{
		$commentModel = new Comment();
		$commentModel->update($id, ['status' => 'approved']);
		$this->redirect('/df-admin/comments');
	}
	
	public function delete($id)
	{
		$commentModel = new Comment();
		$commentModel->delete($id);
		$this->redirect('/df-admin/comments');
	}
}