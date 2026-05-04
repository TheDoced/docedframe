<?php

/**
 * DocedFrame
 * Role.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Role extends Model
{
	protected $table = 'roles';
	
	public function getByUserId($userId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("
			SELECT r.* FROM roles r
			INNER JOIN role_user ru ON r.id = ru.role_id
			WHERE ru.user_id = :user_id
		");
		$stmt->execute(['user_id' => $userId]);
		return $stmt->fetchAll();
	}
	
	public function assignToUser($userId, $roleId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("INSERT INTO role_user (user_id, role_id) VALUES (:user_id, :role_id)");
		return $stmt->execute([
			'user_id' => $userId,
			'role_id' => $roleId
		]);
	}
	
	public function removeFromUser($userId, $roleId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("DELETE FROM role_user WHERE user_id = :user_id AND role_id = :role_id");
		return $stmt->execute([
			'user_id' => $userId,
			'role_id' => $roleId
		]);
	}
}