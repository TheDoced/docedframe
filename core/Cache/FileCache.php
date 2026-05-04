<?php

/**
 * DocedFrame
 * FileCache.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace Core\Cache;

class FileCache
{
	private $cacheDir;
	private $defaultTtl = 3600; // 1 saat
	
	public function __construct($ttl = 3600)
	{
		$this->cacheDir = __DIR__ . '/../../storage/cache/';
		$this->defaultTtl = $ttl;
		
		if (!is_dir($this->cacheDir)) {
			mkdir($this->cacheDir, 0755, true);
		}
	}
	
	public function set($key, $data, $ttl = null)
	{
		$ttl = $ttl ?: $this->defaultTtl;
		$filename = $this->getFilename($key);
		$cacheData = [
			'expires' => time() + $ttl,
			'data' => $data
		];
		
		return file_put_contents($filename, serialize($cacheData));
	}
	
	public function get($key)
	{
		$filename = $this->getFilename($key);
		
		if (!file_exists($filename)) {
			return null;
		}
		
		$cacheData = unserialize(file_get_contents($filename));
		
		if ($cacheData['expires'] < time()) {
			$this->delete($key);
			return null;
		}
		
		return $cacheData['data'];
	}
	
	public function remember($key, $callback, $ttl = null)
	{
		$cached = $this->get($key);
		
		if ($cached !== null) {
			return $cached;
		}
		
		$data = $callback();
		$this->set($key, $data, $ttl);
		
		return $data;
	}
	
	public function delete($key)
	{
		$filename = $this->getFilename($key);
		
		if (file_exists($filename)) {
			return unlink($filename);
		}
		
		return false;
	}
	
	public function clear()
	{
		$files = glob($this->cacheDir . '*.cache');
		
		foreach ($files as $file) {
			unlink($file);
		}
		
		return true;
	}
	
	private function getFilename($key)
	{
		return $this->cacheDir . md5($key) . '.cache';
	}
}