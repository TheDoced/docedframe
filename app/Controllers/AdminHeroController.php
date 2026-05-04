<?php

/**
 * DocedFrame
 * AdminHeroController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Hero;

class AdminHeroController extends Controller
{
	private $heroModel;
	
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_options')) {
			$this->redirect('/df-admin');
		}
		$this->heroModel = new Hero();
	}
	
	public function index()
	{
		$pdo = $this->heroModel->getPdo();
		$stmt = $pdo->query("SELECT * FROM hero_sections ORDER BY id DESC");
		$heroSections = $stmt->fetchAll();
		
		View::render('admin.hero.index', ['heroSections' => $heroSections]);
	}
	
	public function create()
	{
		View::render('admin.hero.create');
	}
	
	public function store()
	{
		$type = $_POST['type'] ?? 'static';
		$name = $_POST['name'] ?? '';
		$title = $_POST['title'] ?? '';
		$subtitle = $_POST['subtitle'] ?? '';
		$buttonText = $_POST['button_text'] ?? '';
		$buttonUrl = $_POST['button_url'] ?? '#';
		$image = $_POST['image'] ?? '';
		$searchPlaceholder = $_POST['search_placeholder'] ?? 'Ara...';
		
		$sliderItems = '';
		if ($type == 'slider') {
			$sliderItems = json_encode($_POST['slider_items'] ?? []);
		}
		
		$this->heroModel->insert([
			'name' => $name,
			'type' => $type,
			'title' => $title,
			'subtitle' => $subtitle,
			'button_text' => $buttonText,
			'button_url' => $buttonUrl,
			'image' => $image,
			'search_placeholder' => $searchPlaceholder,
			'slider_items' => $sliderItems,
			'status' => 0
		]);
		
		$_SESSION['hero_message'] = 'Hero alanı oluşturuldu.';
		$this->redirect('/df-admin/hero');
	}
	
	public function edit($id)
	{
		$hero = $this->heroModel->find($id);
		$sliders = $this->heroModel->getSliders($hero['slider_items']);
		
		View::render('admin.hero.edit', [
			'hero' => $hero,
			'sliders' => $sliders
		]);
	}
	
	public function update($id)
	{
		$type = $_POST['type'] ?? 'static';
		$name = $_POST['name'] ?? '';
		$title = $_POST['title'] ?? '';
		$subtitle = $_POST['subtitle'] ?? '';
		$buttonText = $_POST['button_text'] ?? '';
		$buttonUrl = $_POST['button_url'] ?? '#';
		$image = $_POST['image'] ?? '';
		$searchPlaceholder = $_POST['search_placeholder'] ?? 'Ara...';
		
		$sliderItems = '';
		if ($type == 'slider') {
			$sliderItems = json_encode($_POST['slider_items'] ?? []);
		}
		
		$this->heroModel->update($id, [
			'name' => $name,
			'type' => $type,
			'title' => $title,
			'subtitle' => $subtitle,
			'button_text' => $buttonText,
			'button_url' => $buttonUrl,
			'image' => $image,
			'search_placeholder' => $searchPlaceholder,
			'slider_items' => $sliderItems
		]);
		
		$_SESSION['hero_message'] = 'Hero alanı güncellendi.';
		$this->redirect('/df-admin/hero');
	}
	
	public function activate($id)
	{
		$this->heroModel->setAsActive($id);
		$_SESSION['hero_message'] = 'Hero alanı aktifleştirildi.';
		$this->redirect('/df-admin/hero');
	}
	
	public function delete($id)
	{
		$this->heroModel->delete($id);
		$_SESSION['hero_message'] = 'Hero alanı silindi.';
		$this->redirect('/df-admin/hero');
	}
}