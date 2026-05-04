<?php
// Auth kontrolü
if (\Core\Auth\Auth::check()) {
	header('Location: /df-admin/dashboard');
	exit;
}

// Hata mesajlarını al
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_errors']);
$success = $_SESSION['auth_success'] ?? '';
unset($_SESSION['auth_success']);
$error = $_SESSION['register_error'] ?? '';
unset($_SESSION['register_error']);

// Sosyal giriş ayarları
$socialLoginEnabled = get_option('social_login_enabled', '1');
$googleEnabled = get_option('google_login_enabled', '1');
$facebookEnabled = get_option('facebook_login_enabled', '1');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo get_option('site_name', 'DocedFrame'); ?> | Kayıt Ol</title>
	<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/themes/default/assets/css/style.css">
</head>
<body class="page-register">

<?php include __DIR__ . '/header.php'; ?>

<main class="register-page">
	<div class="register-container">
		<div class="register-wrapper">
			<div class="register-left">
				<div class="register-content">
					<div class="register-badge">HARİKA BİR SEÇİM</div>
					<h1 class="register-title">Hemen<br><span>Hesap Oluşturun</span></h1>
					<p class="register-description">DocedFrame'e katılın, premium temaları keşfedin, favorilerinizi kaydedin ve özel fırsatlardan yararlanın.</p>
					
					<div class="register-stats">
						<div class="stat-item">
							<span class="stat-number">10K+</span>
							<span class="stat-label">Mutlu Müşteri</span>
						</div>
						<div class="stat-item">
							<span class="stat-number">500+</span>
							<span class="stat-label">Premium Tema</span>
						</div>
						<div class="stat-item">
							<span class="stat-number">7/24</span>
							<span class="stat-label">Destek</span>
						</div>
					</div>
				</div>
			</div>
			
			<div class="register-right">
				<div class="register-form-wrapper">
					<div class="register-header">
						<h2>Kayıt Ol</h2>
						<p>Ücretsiz hesap oluşturun, avantajlardan hemen yararlanmaya başlayın.</p>
					</div>
					
					<?php if ($success): ?>
					<div class="alert alert-success" id="successMessage"><?php echo htmlspecialchars($success); ?></div>
					<?php endif; ?>
					
					<?php if ($error): ?>
					<div class="alert alert-error" id="errorMessage"><?php echo htmlspecialchars($error); ?></div>
					<?php endif; ?>
					
					<div id="toastMessage" class="toast-message" style="display: none;"></div>
					
					<form class="register-form" id="registerForm" action="/kayit" method="POST">
						<div class="form-row">
							<div class="form-group">
								<label>Adınız *</label>
								<div class="input-wrapper">
									<svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
										<circle cx="12" cy="7" r="4"/>
									</svg>
									<input type="text" id="firstName" name="first_name" class="form-input <?php echo isset($errors['first_name']) ? 'error' : ''; ?>" placeholder="Adınız" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
								</div>
								<?php if (isset($errors['first_name'])): ?>
								<div class="field-error"><?php echo $errors['first_name']; ?></div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label>Soyadınız *</label>
								<div class="input-wrapper">
									<svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
										<circle cx="12" cy="7" r="4"/>
									</svg>
									<input type="text" id="lastName" name="last_name" class="form-input <?php echo isset($errors['last_name']) ? 'error' : ''; ?>" placeholder="Soyadınız" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
								</div>
								<?php if (isset($errors['last_name'])): ?>
								<div class="field-error"><?php echo $errors['last_name']; ?></div>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="form-group">
							<label>E-posta Adresiniz *</label>
							<div class="input-wrapper">
								<svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
									<polyline points="22,6 12,13 2,6"/>
								</svg>
								<input type="email" id="email" name="email" class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" placeholder="ornek@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
							</div>
							<?php if (isset($errors['email'])): ?>
							<div class="field-error"><?php echo $errors['email']; ?></div>
							<?php endif; ?>
						</div>
						
						<div class="form-row">
							<div class="form-group">
								<label>Şifre *</label>
								<div class="input-wrapper">
									<svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
										<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
									</svg>
									<input type="password" id="password" name="password" class="form-input password-input <?php echo isset($errors['password']) ? 'error' : ''; ?>" placeholder="Şifreniz" required>
									<button type="button" class="toggle-password" data-target="password" tabindex="-1">
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
											<circle cx="12" cy="12" r="3"/>
										</svg>
									</button>
								</div>
								<?php if (isset($errors['password'])): ?>
								<div class="field-error"><?php echo $errors['password']; ?></div>
								<?php endif; ?>
							</div>
							<div class="form-group">
								<label>Şifre Tekrar *</label>
								<div class="input-wrapper">
									<svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
										<path d="M7 11V7a5 5 0 0 1 10 0v4"/>
									</svg>
									<input type="password" id="confirmPassword" name="confirm_password" class="form-input <?php echo isset($errors['confirm_password']) ? 'error' : ''; ?>" placeholder="Şifreniz tekrar" required>
									<button type="button" class="toggle-password" data-target="confirmPassword" tabindex="-1">
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
											<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
											<circle cx="12" cy="12" r="3"/>
										</svg>
									</button>
								</div>
								<?php if (isset($errors['confirm_password'])): ?>
								<div class="field-error"><?php echo $errors['confirm_password']; ?></div>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="form-group password-strength">
							<div class="strength-bar">
								<div class="strength-progress"></div>
							</div>
							<div class="strength-text">Şifre güvenliği</div>
						</div>
						
						<div class="form-group checkbox-group">
							<label class="checkbox-label">
								<input type="checkbox" name="terms" id="terms" required>
								<span class="checkbox-custom"></span>
								<span><a href="/gizlilik">Kullanım Koşulları</a> ve <a href="/gizlilik">Gizlilik Politikası</a>'nı okudum ve kabul ediyorum.</span>
							</label>
							<?php if (isset($errors['terms'])): ?>
							<div class="field-error"><?php echo $errors['terms']; ?></div>
							<?php endif; ?>
						</div>
						
						<div class="form-group checkbox-group">
							<label class="checkbox-label">
								<input type="checkbox" name="newsletter" id="newsletter">
								<span class="checkbox-custom"></span>
								<span>Bültenimize abone olmak istiyorum.</span>
							</label>
						</div>
						
						<button type="submit" class="register-btn">Hesap Oluştur</button>
					</form>
					
					<?php if ($socialLoginEnabled == '1' && ($googleEnabled == '1' || $facebookEnabled == '1')): ?>
					<div class="register-divider">
						<span>veya</span>
					</div>
					
					<div class="social-register">
						<?php if ($googleEnabled == '1'): ?>
						<button class="social-btn google" id="googleRegisterBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none">
								<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
								<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
								<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
								<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
							</svg>
							Google ile Kayıt Ol
						</button>
						<?php endif; ?>
						<?php if ($facebookEnabled == '1'): ?>
						<button class="social-btn facebook" id="facebookRegisterBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
							</svg>
							Facebook ile Kayıt Ol
						</button>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					
					<div class="register-footer">
						<p>Zaten hesabınız var mı? <a href="/df-admin/login">Giriş Yapın</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include __DIR__ . '/footer.php'; ?>