<?php

/**
 * DocedFrame
 * Menu.php
 * Versiyon: 1.2
 * Tarih: 03.05.2026
 */

namespace App\Models;

use Core\Model;

class Menu extends Model
{
	protected $table = 'menus';
	
	public function getItems($menuId)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("SELECT * FROM menu_items WHERE menu_id = :menu_id ORDER BY position ASC");
		$stmt->execute(['menu_id' => $menuId]);
		$items = $stmt->fetchAll();
		return $this->buildTree($items);
	}
	
	private function buildTree($items, $parentId = 0)
	{
		$tree = [];
		foreach ($items as $item) {
			if ($item['parent_id'] == $parentId) {
				$children = $this->buildTree($items, $item['id']);
				if (!empty($children)) {
					$item['children'] = $children;
				}
				$tree[] = $item;
			}
		}
		return $tree;
	}
	
	public function getByLocation($location)
	{
		$pdo = $this->pdo;
		$stmt = $pdo->prepare("SELECT * FROM menus WHERE location = :location LIMIT 1");
		$stmt->execute(['location' => $location]);
		$menu = $stmt->fetch();
		
		if ($menu) {
			$menu['items'] = $this->getItems($menu['id']);
			return $menu;
		}
		return null;
	}
}