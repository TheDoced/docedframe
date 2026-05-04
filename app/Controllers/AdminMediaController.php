<?php

/**
 * DocedFrame
 * AdminMediaController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\Media;

class AdminMediaController extends Controller
{
	private $uploadDir;
	
	public function __construct()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin');
		}
		$this->uploadDir = __DIR__ . '/../../public/uploads/';
	}
	
	public function index()
	{
		$mediaModel = new Media();
		$mediaFiles = $mediaModel->all();
		
		View::render('admin.media.index', ['mediaFiles' => $mediaFiles]);
	}
	
	public function upload()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->redirect('/df-admin/media');
		}
		
		if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
			echo "Dosya yüklenirken hata oluştu.";
			return;
		}
		
		$file = $_FILES['file'];
		$originalName = $file['name'];
		$tmpName = $file['tmp_name'];
		$mimeType = $file['type'];
		$size = $file['size'];
		
		$extension = pathinfo($originalName, PATHINFO_EXTENSION);
		$filename = uniqid() . '.' . $extension;
		$destination = $this->uploadDir . $filename;
		
		if (!is_dir($this->uploadDir)) {
			mkdir($this->uploadDir, 0755, true);
		}
		
		if (move_uploaded_file($tmpName, $destination)) {
			$mediaModel = new Media();
			$mediaModel->insert([
				'filename' => $filename,
				'original_name' => $originalName,
				'path' => '/uploads/' . $filename,
				'mime_type' => $mimeType,
				'size' => $size,
				'created_by' => Auth::id()
			]);
		}
		
		$this->redirect('/df-admin/media');
	}
	
	public function delete($id)
	{
		$mediaModel = new Media();
		$media = $mediaModel->find($id);
		
		if ($media) {
			$filePath = __DIR__ . '/../../public' . $media['path'];
			if (file_exists($filePath)) {
				unlink($filePath);
			}
			$mediaModel->delete($id);
		}
		
		$this->redirect('/df-admin/media');
	}
	
	public function ajaxUpload()
	{
		if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
			echo json_encode(['error' => 'Dosya yüklenemedi']);
			return;
		}
		
		$file = $_FILES['file'];
		$originalName = $file['name'];
		$tmpName = $file['tmp_name'];
		$mimeType = $file['type'];
		$size = $file['size'];
		
		$extension = pathinfo($originalName, PATHINFO_EXTENSION);
		$filename = uniqid() . '.' . $extension;
		$destination = $this->uploadDir . $filename;
		
		if (!is_dir($this->uploadDir)) {
			mkdir($this->uploadDir, 0755, true);
		}
		
		if (move_uploaded_file($tmpName, $destination)) {
			$mediaModel = new Media();
			$mediaId = $mediaModel->insert([
				'filename' => $filename,
				'original_name' => $originalName,
				'path' => '/uploads/' . $filename,
				'mime_type' => $mimeType,
				'size' => $size,
				'created_by' => Auth::id()
			]);
			
			echo json_encode([
				'success' => true,
				'id' => $mediaId,
				'url' => '/uploads/' . $filename,
				'filename' => $originalName
			]);
		} else {
			echo json_encode(['error' => 'Dosya taşınamadı']);
		}
	}
}