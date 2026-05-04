<?php

/**
 * DocedFrame
 * AdminMenuController.php
 * Versiyon: 2.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Menu;
use Exception;

class AdminMenuController extends Controller
{
	private $menuModel;
	
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_options')) {
			$this->redirect('/df-admin');
		}
		$this->menuModel = new Menu();
	}
	
	public function index()
	{
		$pdo = $this->menuModel->getPdo();
		$stmt = $pdo->query("SELECT * FROM menus ORDER BY id DESC");
		$menus = $stmt->fetchAll();
		
		View::render('admin.menus.index', ['menus' => $menus]);
	}
	
	public function create()
	{
		View::render('admin.menus.create');
	}
	
	public function store()
	{
		$name = $_POST['name'] ?? '';
		$slug = $this->createSlug($name);
		$location = $_POST['location'] ?? '';
		
		$this->menuModel->insert([
			'name' => $name,
			'slug' => $slug,
			'location' => $location
		]);
		
		$_SESSION['menu_message'] = 'Menü oluşturuldu.';
		$this->redirect('/df-admin/menus');
	}
	
	public function edit($id)
	{
		$menu = $this->menuModel->find($id);
		$items = $this->menuModel->getItems($id);
		
		$pdo = $this->menuModel->getPdo();
		$stmt = $pdo->query("SELECT * FROM posts WHERE status = 'publish' ORDER BY id DESC");
		$posts = $stmt->fetchAll();
		
		$stmt = $pdo->query("SELECT id, name, slug FROM terms WHERE taxonomy = 'category'");
		$categories = $stmt->fetchAll();
		
		View::render('admin.menus.edit', [
			'menu' => $menu,
			'items' => $items,
			'posts' => $posts,
			'categories' => $categories
		]);
	}
	
	public function update($id)
	{
		$name = $_POST['name'] ?? '';
		$location = $_POST['location'] ?? '';
		
		$this->menuModel->update($id, [
			'name' => $name,
			'location' => $location
		]);
		
		$_SESSION['menu_message'] = 'Menü güncellendi.';
		$this->redirect('/df-admin/menus/edit/' . $id);
	}
	
	public function addItem($menuId)
{
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $parentId = (int)($_POST['parent_id'] ?? 0);
    $target = $_POST['target'] ?? '_self';
    $menuType = $_POST['menu_type'] ?? 'default';
    $icon = $_POST['icon'] ?? '';
    
    $pdo = $this->menuModel->getPdo();
    $stmt = $pdo->prepare("SELECT MAX(position) as max_pos FROM menu_items WHERE menu_id = :menu_id");
    $stmt->execute(['menu_id' => $menuId]);
    $maxPos = $stmt->fetch()['max_pos'] ?? 0;
    
    $stmt = $pdo->prepare("INSERT INTO menu_items (menu_id, parent_id, title, url, target, position, menu_type, icon) VALUES (:menu_id, :parent_id, :title, :url, :target, :position, :menu_type, :icon)");
    $stmt->execute([
        'menu_id' => $menuId,
        'parent_id' => $parentId,
        'title' => $title,
        'url' => $url,
        'target' => $target,
        'position' => $maxPos + 1,
        'menu_type' => $menuType,
        'icon' => $icon
    ]);
    
    $_SESSION['menu_message'] = 'Menü öğesi eklendi.';
    $this->redirect('/df-admin/menus/edit/' . $menuId);
}
	
	public function updateItems($menuId)
{
    $itemsOrder = $_POST['items_order'] ?? '';
    
    if (empty($itemsOrder)) {
        $_SESSION['menu_message'] = 'Sıralama verisi alınamadı.';
        $this->redirect('/df-admin/menus/edit/' . $menuId);
        return;
    }
    
    // JSON verisini çöz
    $items = json_decode($itemsOrder, true);
    
    if (!is_array($items)) {
        $_SESSION['menu_message'] = 'Geçersiz sıralama verisi.';
        $this->redirect('/df-admin/menus/edit/' . $menuId);
        return;
    }
    
    $pdo = $this->menuModel->getPdo();
    
    try {
        foreach ($items as $position => $itemData) {
            $itemId = $itemData['id'];
            $parentId = $itemData['parent_id'] ?? 0;
            
            $stmt = $pdo->prepare("UPDATE menu_items SET position = :position, parent_id = :parent_id WHERE id = :id AND menu_id = :menu_id");
            $stmt->execute([
                'position' => (int)$position,
                'parent_id' => (int)$parentId,
                'id' => (int)$itemId,
                'menu_id' => $menuId
            ]);
        }
        
        $_SESSION['menu_message'] = 'Menü sıralaması kaydedildi.';
        
    } catch (Exception $e) {
        $_SESSION['menu_message'] = 'Hata: ' . $e->getMessage();
    }
    
    $this->redirect('/df-admin/menus/edit/' . $menuId);
}
	
	public function updateItem()
	{
		$id = $_POST['id'] ?? 0;
		$title = $_POST['title'] ?? '';
		$url = $_POST['url'] ?? '';
		
		$pdo = $this->menuModel->getPdo();
		$stmt = $pdo->prepare("UPDATE menu_items SET title = :title, url = :url WHERE id = :id");
		$stmt->execute(['title' => $title, 'url' => $url, 'id' => $id]);
		
		echo json_encode(['success' => true]);
		exit;
	}
	
	public function deleteItem($menuId, $itemId)
	{
		$pdo = $this->menuModel->getPdo();
		$stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = :id AND menu_id = :menu_id");
		$stmt->execute(['id' => $itemId, 'menu_id' => $menuId]);
		
		$_SESSION['menu_message'] = 'Menü öğesi silindi.';
		$this->redirect('/df-admin/menus/edit/' . $menuId);
	}
	
	public function delete($id)
	{
		$this->menuModel->delete($id);
		
		$_SESSION['menu_message'] = 'Menü silindi.';
		$this->redirect('/df-admin/menus');
	}
	
	private function createSlug($text)
	{
		$text = strtolower($text);
		$text = preg_replace('/[^a-z0-9-]/', '-', $text);
		$text = preg_replace('/-+/', '-', $text);
		return trim($text, '-');
	}
}