<?php

/**
 * DocedFrame
 * TermRelationship.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class TermRelationship extends Model
{
	protected $table = 'term_relationships';
	
	public function attach($postId, $termId)
	{
		$existing = $this->where('post_id', $postId);
		foreach ($existing as $item) {
			if ($item['term_id'] == $termId) {
				return false;
			}
		}
		
		return $this->insert([
			'post_id' => $postId,
			'term_id' => $termId
		]);
	}
	
	public function detach($postId, $termId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE post_id = :post_id AND term_id = :term_id");
		return $stmt->execute(['post_id' => $postId, 'term_id' => $termId]);
	}
	
	public function getTermsByPost($postId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("
			SELECT t.* FROM terms t
			INNER JOIN term_relationships tr ON t.id = tr.term_id
			WHERE tr.post_id = :post_id
		");
		$stmt->execute(['post_id' => $postId]);
		return $stmt->fetchAll();
	}
}