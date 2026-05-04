<?php

/**
 * DocedFrame
 * Post.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Post extends Model
{
	protected $table = 'posts';
	
	public function getPostsByType($type = 'post')
	{
		return $this->where('type', $type);
	}
	
	public function getPublished()
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("SELECT * FROM {$this->table} WHERE status = 'publish' ORDER BY created_at DESC");
		$stmt->execute();
		return $stmt->fetchAll();
	}
}