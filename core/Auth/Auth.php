<?php

/**
 * DocedFrame
 * Auth.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace Core\Auth;

use Core\Database\Connection;

class Auth
{
	private static $sessionKey = 'user_id';
	private static $currentUser = null;
	
	public static function attempt($email, $password, $remember = false)
	{
		$pdo = Connection::getInstance()->getPdo();
		
		$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND status = 1");
		$stmt->execute(['email' => $email]);
		$user = $stmt->fetch();
		
		if ($user && password_verify($password, $user['password'])) {
			$_SESSION[self::$sessionKey] = $user['id'];
			$_SESSION['user_email'] = $user['email'];
			$_SESSION['user_name'] = $user['display_name'];
			self::$currentUser = $user;
			
			if ($remember) {
				$token = bin2hex(random_bytes(32));
				setcookie('remember_token', $token, time() + 86400 * 30, '/');
				$stmt = $pdo->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
				$stmt->execute(['token' => $token, 'id' => $user['id']]);
			}
			
			return true;
		}
		
		return false;
	}
	
	public static function check()
	{
		return isset($_SESSION[self::$sessionKey]);
	}
	
	public static function user()
	{
		if (self::$currentUser !== null) {
			return self::$currentUser;
		}
		
		if (!self::check()) {
			return null;
		}
		
		$pdo = Connection::getInstance()->getPdo();
		$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->execute(['id' => $_SESSION[self::$sessionKey]]);
		self::$currentUser = $stmt->fetch();
		
		return self::$currentUser;
	}
	
	public static function id()
	{
		return $_SESSION[self::$sessionKey] ?? null;
	}
	
	public static function logout()
	{
		// Remember token'ı temizle
		if (self::check()) {
			$pdo = Connection::getInstance()->getPdo();
			$stmt = $pdo->prepare("UPDATE users SET remember_token = NULL WHERE id = :id");
			$stmt->execute(['id' => self::id()]);
		}
		
		session_destroy();
		$_SESSION = [];
		setcookie('remember_token', '', time() - 3600, '/');
		self::$currentUser = null;
	}
	
	public static function checkRememberToken()
	{
		if (self::check()) return true;
		
		$token = $_COOKIE['remember_token'] ?? '';
		if (empty($token)) return false;
		
		$pdo = Connection::getInstance()->getPdo();
		$stmt = $pdo->prepare("SELECT * FROM users WHERE remember_token = :token AND status = 1");
		$stmt->execute(['token' => $token]);
		$user = $stmt->fetch();
		
		if ($user) {
			$_SESSION[self::$sessionKey] = $user['id'];
			$_SESSION['user_email'] = $user['email'];
			$_SESSION['user_name'] = $user['display_name'];
			self::$currentUser = $user;
			return true;
		}
		
		return false;
	}
	
	public static function can($capability)
	{
		if (!self::check()) {
			return false;
		}
		
		$user = self::user();
		if (!$user) return false;
		
		$pdo = Connection::getInstance()->getPdo();
		$stmt = $pdo->prepare("
			SELECT r.capabilities FROM roles r
			INNER JOIN role_user ru ON r.id = ru.role_id
			WHERE ru.user_id = :user_id
			LIMIT 1
		");
		$stmt->execute(['user_id' => $user['id']]);
		$role = $stmt->fetch();
		
		if ($role && !empty($role['capabilities'])) {
			$caps = json_decode($role['capabilities'], true);
			return isset($caps[$capability]) && $caps[$capability] === true;
		}
		
		return false;
	}
}