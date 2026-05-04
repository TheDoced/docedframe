<?php

/**
 * DocedFrame
 * AdminBackupController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;

class AdminBackupController extends Controller
{
	private $backupDir;
	
	public function __construct()
	{
		if (!Auth::check() || !Auth::can('manage_options')) {
			$this->redirect('/df-admin');
		}
		
		$this->backupDir = __DIR__ . '/../../storage/backups/';
		
		if (!is_dir($this->backupDir)) {
			mkdir($this->backupDir, 0755, true);
		}
	}
	
	public function index()
	{
		$backups = $this->getBackupList();
		
		View::render('admin.backup.index', ['backups' => $backups]);
	}
	
	public function create()
	{
		$filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
		$filepath = $this->backupDir . $filename;
		
		$this->exportDatabase($filepath);
		
		$_SESSION['backup_message'] = 'Yedek başarıyla oluşturuldu: ' . $filename;
		$this->redirect('/df-admin/backup');
	}
	
	public function download($filename)
	{
		$filepath = $this->backupDir . $filename;
		
		if (file_exists($filepath)) {
			header('Content-Type: application/sql');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Length: ' . filesize($filepath));
			readfile($filepath);
			exit;
		}
		
		$_SESSION['backup_message'] = 'Dosya bulunamadı.';
		$this->redirect('/df-admin/backup');
	}
	
	public function restore($filename)
	{
		$filepath = $this->backupDir . $filename;
		
		if (file_exists($filepath)) {
			$this->importDatabase($filepath);
			$_SESSION['backup_message'] = 'Yedek başarıyla geri yüklendi: ' . $filename;
		} else {
			$_SESSION['backup_message'] = 'Dosya bulunamadı.';
		}
		
		$this->redirect('/df-admin/backup');
	}
	
	public function delete($filename)
	{
		$filepath = $this->backupDir . $filename;
		
		if (file_exists($filepath)) {
			unlink($filepath);
			$_SESSION['backup_message'] = 'Yedek silindi: ' . $filename;
		}
		
		$this->redirect('/df-admin/backup');
	}
	
	private function getBackupList()
	{
		$backups = [];
		
		$files = glob($this->backupDir . 'backup_*.sql');
		
		foreach ($files as $file) {
			$filename = basename($file);
			$size = filesize($file);
			$date = date('Y-m-d H:i:s', filemtime($file));
			
			$backups[] = [
				'name' => $filename,
				'size' => $this->formatSize($size),
				'date' => $date
			];
		}
		
		usort($backups, function($a, $b) {
			return strtotime($b['date']) - strtotime($a['date']);
		});
		
		return $backups;
	}
	
	private function exportDatabase($filepath)
	{
		$pdo = \Core\Database\Connection::getInstance()->getPdo();
		
		$tables = [];
		$stmt = $pdo->query("SHOW TABLES");
		while ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
			$tables[] = $row[0];
		}
		
		$output = "-- DocedFrame Database Backup\n";
		$output .= "-- Oluşturulma: " . date('Y-m-d H:i:s') . "\n\n";
		$output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
		
		foreach ($tables as $table) {
			$output .= "-- Tablo: {$table}\n";
			$output .= "DROP TABLE IF EXISTS `{$table}`;\n";
			
			$stmt = $pdo->query("SHOW CREATE TABLE `{$table}`");
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$output .= $row['Create Table'] . ";\n\n";
			
			$stmt = $pdo->query("SELECT * FROM `{$table}`");
			$rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			foreach ($rows as $row) {
				$columns = array_keys($row);
				$values = array_map(function($value) use ($pdo) {
					if ($value === null) return 'NULL';
					return $pdo->quote($value);
				}, array_values($row));
				
				$output .= "INSERT INTO `{$table}` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
			}
			
			$output .= "\n";
		}
		
		$output .= "SET FOREIGN_KEY_CHECKS=1;\n";
		
		file_put_contents($filepath, $output);
	}
	
	private function importDatabase($filepath)
	{
		$pdo = \Core\Database\Connection::getInstance()->getPdo();
		
		$sql = file_get_contents($filepath);
		
		$pdo->exec("SET FOREIGN_KEY_CHECKS=0");
		
		$queries = explode(";\n", $sql);
		
		foreach ($queries as $query) {
			$query = trim($query);
			if (!empty($query)) {
				try {
					$pdo->exec($query);
				} catch (\PDOException $e) {
					// Hata durumunda devam et
				}
			}
		}
		
		$pdo->exec("SET FOREIGN_KEY_CHECKS=1");
	}
	
	private function formatSize($bytes)
	{
		if ($bytes >= 1048576) {
			return round($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			return round($bytes / 1024, 2) . ' KB';
		}
		return $bytes . ' B';
	}
}