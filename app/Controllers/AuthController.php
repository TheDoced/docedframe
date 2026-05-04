<?php

/**
 * DocedFrame
 * AuthController.php
 * Versiyon: 1.1
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Auth\Auth;
use App\Models\User;

class AuthController extends Controller
{
	public function login()
	{
		if (Auth::check()) {
			$this->redirect('/df-admin/dashboard');
		}
		View::render('auth.login');
	}
	
	public function doLogin()
	{
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		$remember = isset($_POST['remember']) ? true : false;
		
		if (Auth::attempt($email, $password, $remember)) {
			// 2FA kontrolü
			$user = Auth::user();
			if ($user && $user['twofa_enabled'] == 1) {
				$_SESSION['2fa_user_id'] = $user['id'];
				$this->redirect('/df-admin/2fa');
				return;
			}
			$this->redirect('/df-admin/dashboard');
		} else {
			$_SESSION['auth_error'] = 'Hatalı e-posta veya şifre.';
			$this->redirect('/df-admin/login');
		}
	}
	
	public function twofa()
	{
		if (!isset($_SESSION['2fa_user_id'])) {
			$this->redirect('/df-admin/login');
		}
		View::render('auth.twofa');
	}
	
	public function verifyTwofa()
	{
		$code = $_POST['code'] ?? '';
		$userId = $_SESSION['2fa_user_id'] ?? 0;
		
		$userModel = new User();
		$user = $userModel->find($userId);
		
		if ($user && $this->verifyGoogle2FA($user['twofa_secret'], $code)) {
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['user_email'] = $user['email'];
			$_SESSION['user_name'] = $user['display_name'];
			unset($_SESSION['2fa_user_id']);
			$this->redirect('/df-admin/dashboard');
		} else {
			$_SESSION['auth_error'] = 'Geçersiz 2FA kodu.';
			$this->redirect('/df-admin/2fa');
		}
	}
	
	public function register()
	{
		if (Auth::check()) {
			$this->redirect('/df-admin/dashboard');
		}
		// Tema klasöründeki register.php'yi kullan
		include __DIR__ . '/../../themes/default/register.php';
		exit;
	}
	
	public function doRegister()
	{
		// AJAX isteği kontrolü
		$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
		
		$firstName = trim($_POST['first_name'] ?? '');
		$lastName = trim($_POST['last_name'] ?? '');
		$displayName = $firstName . ' ' . $lastName;
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$confirmPassword = $_POST['confirm_password'] ?? '';
		$newsletter = isset($_POST['newsletter']) ? 1 : 0;
		$terms = isset($_POST['terms']) ? 1 : 0;
		
		// Validasyon
		$errors = [];
		
		if (empty($firstName)) {
			$errors['first_name'] = 'Lütfen adınızı girin.';
		} elseif (strlen($firstName) < 2) {
			$errors['first_name'] = 'Ad en az 2 karakter olmalıdır.';
		}
		
		if (empty($lastName)) {
			$errors['last_name'] = 'Lütfen soyadınızı girin.';
		} elseif (strlen($lastName) < 2) {
			$errors['last_name'] = 'Soyad en az 2 karakter olmalıdır.';
		}
		
		if (empty($email)) {
			$errors['email'] = 'Lütfen e-posta adresinizi girin.';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Lütfen geçerli bir e-posta adresi girin.';
		}
		
		if (empty($password)) {
			$errors['password'] = 'Lütfen şifrenizi girin.';
		} elseif (strlen($password) < 6) {
			$errors['password'] = 'Şifre en az 6 karakter olmalıdır.';
		} elseif (!preg_match('/[A-Z]/', $password)) {
			$errors['password'] = 'Şifre en az bir büyük harf içermelidir.';
		} elseif (!preg_match('/[0-9]/', $password)) {
			$errors['password'] = 'Şifre en az bir sayı içermelidir.';
		}
		
		if ($password !== $confirmPassword) {
			$errors['confirm_password'] = 'Şifreler eşleşmiyor.';
		}
		
		if (!$terms) {
			$errors['terms'] = 'Kullanım koşullarını kabul etmelisiniz.';
		}
		
		// E-posta kontrolü
		$userModel = new User();
		$existing = $userModel->where('email', $email);
		
		if (!empty($existing)) {
			$errors['email'] = 'Bu e-posta adresi zaten kullanılıyor.';
		}
		
		if (!empty($errors)) {
			if ($isAjax) {
				header('Content-Type: application/json');
				echo json_encode(['success' => false, 'errors' => $errors]);
				exit;
			} else {
				$_SESSION['register_errors'] = $errors;
				$this->redirect('/kayit');
				return;
			}
		}
		
		// Kullanıcı oluştur
		$userId = $userModel->insert([
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'display_name' => $displayName,
			'status' => 1
		]);
		
		if ($userId) {
			// Kullanıcıya "subscriber" rolü ata
			$pdo = $userModel->getPdo();
			$stmt = $pdo->prepare("SELECT id FROM roles WHERE slug = 'subscriber' LIMIT 1");
			$stmt->execute();
			$role = $stmt->fetch();
			
			if ($role) {
				$stmt = $pdo->prepare("INSERT INTO role_user (user_id, role_id) VALUES (:user_id, :role_id)");
				$stmt->execute(['user_id' => $userId, 'role_id' => $role['id']]);
			}
			
			// Newsletter aboneliği
			if ($newsletter) {
				$stmt = $pdo->prepare("INSERT IGNORE INTO newsletter (email, created_at) VALUES (:email, NOW())");
				$stmt->execute(['email' => $email]);
			}
			
			if ($isAjax) {
				header('Content-Type: application/json');
				echo json_encode(['success' => true, 'message' => 'Kaydınız başarıyla oluşturuldu! Giriş sayfasına yönlendiriliyorsunuz.']);
				exit;
			} else {
				$_SESSION['auth_success'] = 'Kaydınız başarıyla oluşturuldu! Giriş yapabilirsiniz.';
				$this->redirect('/df-admin/login');
			}
		} else {
			if ($isAjax) {
				header('Content-Type: application/json');
				echo json_encode(['success' => false, 'message' => 'Kayıt sırasında bir hata oluştu.']);
				exit;
			} else {
				$_SESSION['register_error'] = 'Kayıt sırasında bir hata oluştu.';
				$this->redirect('/kayit');
			}
		}
	}
	
	public function logout()
	{
		Auth::logout();
		$this->redirect('/df-admin/login');
	}
	
	public function forgotPassword()
	{
		if (Auth::check()) {
			$this->redirect('/df-admin/dashboard');
		}
		View::render('auth.forgot-password');
	}
	
	public function doForgotPassword()
	{
		$email = $_POST['email'] ?? '';
		
		$userModel = new User();
		$user = $userModel->where('email', $email);
		
		if (!empty($user)) {
			// Reset token oluştur
			$token = bin2hex(random_bytes(32));
			$expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
			
			$pdo = $userModel->getPdo();
			$pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires)")->execute([
				'email' => $email,
				'token' => $token,
				'expires' => $expires
			]);
			
			$_SESSION['auth_success'] = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
		} else {
			$_SESSION['auth_error'] = 'Bu e-posta adresiyle kayıtlı kullanıcı bulunamadı.';
		}
		
		$this->redirect('/sifremi-unuttum');
	}
	
	public function resetPassword($token)
	{
		$pdo = (new User())->getPdo();
		$stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW()");
		$stmt->execute(['token' => $token]);
		$reset = $stmt->fetch();
		
		if (!$reset) {
			$_SESSION['auth_error'] = 'Geçersiz veya süresi dolmuş bağlantı.';
			$this->redirect('/sifremi-unuttum');
			return;
		}
		
		View::render('auth.reset-password', ['token' => $token, 'email' => $reset['email']]);
	}
	
	public function doResetPassword()
	{
		$token = $_POST['token'] ?? '';
		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';
		$confirmPassword = $_POST['confirm_password'] ?? '';
		
		if ($password !== $confirmPassword) {
			$_SESSION['auth_error'] = 'Şifreler eşleşmiyor.';
			$this->redirect('/sifre-sifirla/' . $token);
			return;
		}
		
		if (strlen($password) < 6) {
			$_SESSION['auth_error'] = 'Şifre en az 6 karakter olmalıdır.';
			$this->redirect('/sifre-sifirla/' . $token);
			return;
		}
		
		$userModel = new User();
		$user = $userModel->where('email', $email);
		
		if (!empty($user)) {
			$userModel->update($user[0]['id'], [
				'password' => password_hash($password, PASSWORD_DEFAULT)
			]);
			
			// Token'ı temizle
			$pdo = $userModel->getPdo();
			$pdo->prepare("DELETE FROM password_resets WHERE token = :token")->execute(['token' => $token]);
			
			$_SESSION['auth_success'] = 'Şifreniz başarıyla değiştirildi. Giriş yapabilirsiniz.';
			$this->redirect('/df-admin/login');
		} else {
			$_SESSION['auth_error'] = 'Bir hata oluştu.';
			$this->redirect('/sifremi-unuttum');
		}
	}
	
	public function setup2fa()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin/login');
		}
		
		$user = Auth::user();
		
		if ($user['twofa_enabled']) {
			$this->redirect('/df-admin/dashboard');
		}
		
		$secret = $this->generateGoogle2FASecret();
		$_SESSION['2fa_temp_secret'] = $secret;
		
		$qrCodeUrl = $this->getGoogle2FAQRCodeUrl($secret, $user['email']);
		
		View::render('auth.setup-2fa', [
			'secret' => $secret,
			'qrCodeUrl' => $qrCodeUrl
		]);
	}
	
	public function enable2fa()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin/login');
		}
		
		$code = $_POST['code'] ?? '';
		$secret = $_SESSION['2fa_temp_secret'] ?? '';
		
		if ($this->verifyGoogle2FA($secret, $code)) {
			$userModel = new User();
			$userModel->update(Auth::id(), [
				'twofa_secret' => $secret,
				'twofa_enabled' => 1
			]);
			
			unset($_SESSION['2fa_temp_secret']);
			$_SESSION['auth_success'] = '2FA başarıyla etkinleştirildi.';
			$this->redirect('/df-admin/dashboard');
		} else {
			$_SESSION['auth_error'] = 'Geçersiz doğrulama kodu.';
			$this->redirect('/df-admin/2fa/setup');
		}
	}
	
	public function disable2fa()
	{
		if (!Auth::check()) {
			$this->redirect('/df-admin/login');
		}
		
		$code = $_POST['code'] ?? '';
		$user = Auth::user();
		
		if ($this->verifyGoogle2FA($user['twofa_secret'], $code)) {
			$userModel = new User();
			$userModel->update(Auth::id(), [
				'twofa_secret' => null,
				'twofa_enabled' => 0
			]);
			$_SESSION['auth_success'] = '2FA devre dışı bırakıldı.';
		} else {
			$_SESSION['auth_error'] = 'Geçersiz doğrulama kodu.';
		}
		
		$this->redirect('/df-admin/dashboard');
	}
	
	// 2FA Helper fonksiyonları
	private function generateGoogle2FASecret()
	{
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
		$secret = '';
		for ($i = 0; $i < 16; $i++) {
			$secret .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $secret;
	}
	
	private function getGoogle2FAQRCodeUrl($secret, $email)
	{
		$issuer = get_option('site_name', 'DocedFrame');
		$encodedIssuer = urlencode($issuer);
		$encodedEmail = urlencode($email);
		return "https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/{$encodedIssuer}:{$encodedEmail}?secret={$secret}&issuer={$encodedIssuer}";
	}
	
	private function verifyGoogle2FA($secret, $code)
	{
		$time = floor(time() / 30);
		for ($i = -1; $i <= 1; $i++) {
			$calculatedCode = $this->generateGoogle2FACode($secret, $time + $i);
			if ($calculatedCode == $code) {
				return true;
			}
		}
		return false;
	}
	
	private function generateGoogle2FACode($secret, $timeSlice)
	{
		$secret = $this->base32Decode($secret);
		$time = pack('N', $timeSlice);
		$time = str_pad($time, 8, "\0", STR_PAD_LEFT);
		
		$hash = hash_hmac('sha1', $time, $secret, true);
		$offset = ord($hash[19]) & 0xf;
		$code = (
			((ord($hash[$offset]) & 0x7f) << 24) |
			((ord($hash[$offset + 1]) & 0xff) << 16) |
			((ord($hash[$offset + 2]) & 0xff) << 8) |
			(ord($hash[$offset + 3]) & 0xff)
		) % 1000000;
		
		return str_pad($code, 6, '0', STR_PAD_LEFT);
	}
	
	private function base32Decode($secret)
	{
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
		$output = '';
		$buffer = 0;
		$bits = 0;
		
		for ($i = 0; $i < strlen($secret); $i++) {
			$buffer <<= 5;
			$buffer += strpos($alphabet, $secret[$i]);
			$bits += 5;
			
			while ($bits >= 8) {
				$bits -= 8;
				$output .= chr(($buffer >> $bits) & 0xFF);
			}
		}
		return $output;
	}
}