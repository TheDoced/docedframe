<?php

/**
 * DocedFrame
 * Comment.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Comment extends Model
{
	protected $table = 'comments';
	
	public function getByPost($postId)
	{
		return $this->where('post_id', $postId);
	}
	
	public function getApprovedByPost($postId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("SELECT * FROM {$this->table} WHERE post_id = :post_id AND status = 'approved' ORDER BY created_at ASC");
		$stmt->execute(['post_id' => $postId]);
		return $stmt->fetchAll();
	}
}