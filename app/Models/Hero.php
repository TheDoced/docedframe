<?php

/**
 * DocedFrame
 * Hero.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Hero extends Model
{
	protected $table = 'hero_sections';
	
	public function getActive()
	{
		$pdo = $this->pdo;
		$stmt = $pdo->query("SELECT * FROM hero_sections WHERE status = 1 ORDER BY id DESC LIMIT 1");
		return $stmt->fetch();
	}
	
	public function getSliders($sliderItems)
	{
		if (empty($sliderItems)) {
			return [];
		}
		return json_decode($sliderItems, true);
	}
	
	public function setAsActive($id)
	{
		$pdo = $this->pdo;
		$pdo->exec("UPDATE hero_sections SET status = 0");
		$stmt = $pdo->prepare("UPDATE hero_sections SET status = 1 WHERE id = :id");
		$stmt->execute(['id' => $id]);
	}
}