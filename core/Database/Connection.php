<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
	private static $instance = null;
	private $pdo;

	private function __construct()
	{
		$config = $this->loadConfig();

		try {
			$dsn = "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4";

			$this->pdo = new PDO(
				$dsn,
				$config['user'],
				$config['pass'],
				[
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				]
			);

		} catch (PDOException $e) {
			die("Veritabanı bağlantı hatası: " . $e->getMessage());
		}
	}

	private function loadConfig()
	{
		$envFile = __DIR__ . '/../../.env';

		$config = [
			'host' => '127.0.0.1',
			'name' => 'docedframe_db',
			'user' => 'root',
			'pass' => ''
		];

		if (!file_exists($envFile)) {
			return $config;
		}

		$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($lines as $line) {
			$line = trim($line);

			// yorum satırlarını atla
			if ($line === '' || str_starts_with($line, '#')) {
				continue;
			}

			if (!str_contains($line, '=')) {
				continue;
			}

			[$key, $value] = explode('=', $line, 2);

			$key = trim($key);
			$value = trim($value);

			// tırnak temizle
			$value = trim($value, "\"'");

			if (str_starts_with($key, 'DB_')) {
				$key = strtolower(str_replace('DB_', '', $key));

				match ($key) {
					'host' => $config['host'] = $value,
					'name' => $config['name'] = $value,
					'user' => $config['user'] = $value,
					'pass' => $config['pass'] = $value,
					default => null
				};
			}
		}

		return $config;
	}

	public static function getInstance()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getPdo()
	{
		return $this->pdo;
	}
}