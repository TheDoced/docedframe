<?php

/**
 * DocedFrame
 * Term.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Term extends Model
{
	protected $table = 'terms';
	
	public function getByTaxonomy($taxonomy)
	{
		return $this->where('taxonomy', $taxonomy);
	}
	
	public function getPostsByTerm($termId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("
			SELECT p.* FROM posts p
			INNER JOIN term_relationships tr ON p.id = tr.post_id
			WHERE tr.term_id = :term_id
		");
		$stmt->execute(['term_id' => $termId]);
		return $stmt->fetchAll();
	}
}