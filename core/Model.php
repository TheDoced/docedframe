<?php

/**
 * DocedFrame
 * Model.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace Core;

use Core\Database\Connection;

class Model
{
	protected $table;
	protected $pdo;
	
	public function __construct()
	{
		$this->pdo = Connection::getInstance()->getPdo();
	}
	
	public function getPdo()
	{
		return $this->pdo;
	}
	
	public function all()
	{
		$stmt = $this->pdo->query("SELECT * FROM {$this->table}");
		return $stmt->fetchAll();
	}
	
	public function find($id)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}
	
	public function where($column, $value)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value");
		$stmt->execute(['value' => $value]);
		return $stmt->fetchAll();
	}
	
	public function insert($data)
	{
		$columns = implode(', ', array_keys($data));
		$placeholders = ':' . implode(', :', array_keys($data));
		
		$stmt = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
		$stmt->execute($data);
		
		return $this->pdo->lastInsertId();
	}
	
	public function update($id, $data)
	{
		$set = [];
		foreach ($data as $key => $value) {
			$set[] = "{$key} = :{$key}";
		}
		$set = implode(', ', $set);
		$data['id'] = $id;
		
		$stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$set} WHERE id = :id");
		return $stmt->execute($data);
	}
	
	public function delete($id)
	{
		$stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
		return $stmt->execute(['id' => $id]);
	}
}