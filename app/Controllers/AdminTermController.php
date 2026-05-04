<?php

/**
 * DocedFrame
 * AdminTermController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Term;

class AdminTermController extends Controller
{
	public function __construct()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
	}
	
	public function categories()
	{
		$termModel = new Term();
		$categories = $termModel->getByTaxonomy('category');
		
		View::render('admin.terms.categories', ['categories' => $categories]);
	}
	
	public function tags()
	{
		$termModel = new Term();
		$tags = $termModel->getByTaxonomy('tag');
		
		View::render('admin.terms.tags', ['tags' => $tags]);
	}
	
	public function storeCategory()
	{
		$name = $_POST['name'] ?? '';
		$slug = $this->createSlug($name);
		
		$termModel = new Term();
		$termModel->insert([
			'name' => $name,
			'slug' => $slug,
			'taxonomy' => 'category'
		]);
		
		$this->redirect('/df-admin/categories');
	}
	
	public function storeTag()
	{
		$name = $_POST['name'] ?? '';
		$slug = $this->createSlug($name);
		
		$termModel = new Term();
		$termModel->insert([
			'name' => $name,
			'slug' => $slug,
			'taxonomy' => 'tag'
		]);
		
		$this->redirect('/df-admin/tags');
	}
	
	public function deleteCategory($id)
	{
		$termModel = new Term();
		$termModel->delete($id);
		
		$this->redirect('/df-admin/categories');
	}
	
	public function deleteTag($id)
	{
		$termModel = new Term();
		$termModel->delete($id);
		
		$this->redirect('/df-admin/tags');
	}
	
	private function createSlug($text)
	{
		$text = strtolower($text);
		$text = preg_replace('/[^a-z0-9-]/', '-', $text);
		$text = preg_replace('/-+/', '-', $text);
		return trim($text, '-');
	}
}