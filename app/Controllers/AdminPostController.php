<?php

/**
 * DocedFrame
 * AdminPostController.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Post;
use App\Models\Term;
use App\Models\TermRelationship;

class AdminPostController extends Controller
{
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('edit_posts')) {
			$this->redirect('/df-admin');
		}
	}
	
	public function index()
	{
		$postModel = new Post();
		$posts = $postModel->all();
		
		View::render('admin.posts.index', ['posts' => $posts]);
	}
	
	public function create()
	{
		$termModel = new Term();
		$categories = $termModel->getByTaxonomy('category');
		$tags = $termModel->getByTaxonomy('tag');
		
		View::render('admin.posts.create', [
			'categories' => $categories,
			'tags' => $tags
		]);
	}
	
	public function store()
	{
		$title = $_POST['title'] ?? '';
		$content = $_POST['content'] ?? '';
		$type = $_POST['type'] ?? 'post';
		$status = $_POST['status'] ?? 'draft';
		$categories = $_POST['categories'] ?? [];
		$tags = $_POST['tags'] ?? [];
		
		$slug = $this->createSlug($title);
		
		$postModel = new Post();
		$postId = $postModel->insert([
			'title' => $title,
			'slug' => $slug,
			'content' => $content,
			'type' => $type,
			'status' => $status,
			'author_id' => Auth::id()
		]);
		
		$relModel = new TermRelationship();
		
		foreach ($categories as $catId) {
			$relModel->attach($postId, $catId);
		}
		
		foreach ($tags as $tagId) {
			$relModel->attach($postId, $tagId);
		}
		
		$this->redirect('/df-admin/posts');
	}
	
	public function edit($id)
	{
		$postModel = new Post();
		$post = $postModel->find($id);
		
		$termModel = new Term();
		$categories = $termModel->getByTaxonomy('category');
		$tags = $termModel->getByTaxonomy('tag');
		
		$relModel = new TermRelationship();
		$selectedTerms = $relModel->getTermsByPost($id);
		
		$selectedCategories = [];
		$selectedTags = [];
		
		foreach ($selectedTerms as $term) {
			if ($term['taxonomy'] == 'category') {
				$selectedCategories[] = $term['id'];
			} else {
				$selectedTags[] = $term['id'];
			}
		}
		
		View::render('admin.posts.edit', [
			'post' => $post,
			'categories' => $categories,
			'tags' => $tags,
			'selectedCategories' => $selectedCategories,
			'selectedTags' => $selectedTags
		]);
	}
	
	public function update($id)
	{
		$title = $_POST['title'] ?? '';
		$content = $_POST['content'] ?? '';
		$type = $_POST['type'] ?? 'post';
		$status = $_POST['status'] ?? 'draft';
		$categories = $_POST['categories'] ?? [];
		$tags = $_POST['tags'] ?? [];
		
		$postModel = new Post();
		$postModel->update($id, [
			'title' => $title,
			'content' => $content,
			'type' => $type,
			'status' => $status
		]);
		
		$relModel = new TermRelationship();
		
		$oldTerms = $relModel->getTermsByPost($id);
		foreach ($oldTerms as $term) {
			$relModel->detach($id, $term['id']);
		}
		
		foreach ($categories as $catId) {
			$relModel->attach($id, $catId);
		}
		
		foreach ($tags as $tagId) {
			$relModel->attach($id, $tagId);
		}
		
		$this->redirect('/df-admin/posts');
	}
	
	public function delete($id)
	{
		$postModel = new Post();
		$postModel->delete($id);
		
		$this->redirect('/df-admin/posts');
	}
	
	private function createSlug($text)
	{
		$text = strtolower($text);
		$text = preg_replace('/[^a-z0-9-]/', '-', $text);
		$text = preg_replace('/-+/', '-', $text);
		return trim($text, '-');
	}

	public function bulkAction()
	{
		$action = $_POST['bulk_action'] ?? '';
		$postIds = $_POST['post_ids'] ?? [];
		
		if (empty($postIds)) {
			$_SESSION['admin_message'] = 'Lütfen en az bir yazı seçin.';
			$this->redirect('/df-admin/posts');
		}
		
		$postModel = new Post();
		
		switch ($action) {
			case 'delete':
				foreach ($postIds as $id) {
					$postModel->delete($id);
				}
				$_SESSION['admin_message'] = count($postIds) . ' yazı silindi.';
				break;
				
			case 'draft':
				foreach ($postIds as $id) {
					$postModel->update($id, ['status' => 'draft']);
				}
				$_SESSION['admin_message'] = count($postIds) . ' yazı taslak durumuna alındı.';
				break;
				
			case 'publish':
				foreach ($postIds as $id) {
					$postModel->update($id, ['status' => 'publish']);
				}
				$_SESSION['admin_message'] = count($postIds) . ' yazı yayınlandı.';
				break;
				
			case 'change_category':
				$categoryId = $_POST['category_id'] ?? 0;
				if ($categoryId) {
					$relModel = new \App\Models\TermRelationship();
					foreach ($postIds as $id) {
						$relModel->attach($id, $categoryId);
					}
					$_SESSION['admin_message'] = count($postIds) . ' yazının kategorisi değiştirildi.';
				}
				break;
		}
		
		$this->redirect('/df-admin/posts');
	}
}