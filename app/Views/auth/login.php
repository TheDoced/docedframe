<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Giriş Yap - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}
		
		.login-container {
			background: #fff;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 15px 35px rgba(0,0,0,0.2);
			width: 100%;
			max-width: 420px;
		}
		
		.login-container h1 {
			text-align: center;
			margin-bottom: 10px;
			color: #333;
			font-size: 28px;
		}
		
		.login-container .subtitle {
			text-align: center;
			color: #666;
			margin-bottom: 30px;
			font-size: 14px;
		}
		
		.form-group {
			margin-bottom: 20px;
		}
		
		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #555;
			font-size: 14px;
		}
		
		.form-group input {
			width: 100%;
			padding: 12px 15px;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 14px;
			transition: all 0.3s;
		}
		
		.form-group input:focus {
			outline: none;
			border-color: #667eea;
			box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
		}
		
		.checkbox-group {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 20px;
		}
		
		.checkbox-group label {
			display: flex;
			align-items: center;
			gap: 8px;
			font-weight: normal;
			cursor: pointer;
		}
		
		.checkbox-group input {
			width: auto;
		}
		
		.forgot-link {
			color: #667eea;
			text-decoration: none;
			font-size: 13px;
		}
		
		.forgot-link:hover {
			text-decoration: underline;
		}
		
		button {
			width: 100%;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			color: #fff;
			padding: 12px;
			border: none;
			border-radius: 6px;
			font-size: 16px;
			font-weight: 600;
			cursor: pointer;
			transition: opacity 0.3s;
		}
		
		button:hover {
			opacity: 0.9;
		}
		
		.register-link {
			text-align: center;
			margin-top: 20px;
			padding-top: 20px;
			border-top: 1px solid #eee;
			font-size: 14px;
			color: #666;
		}
		
		.register-link a {
			color: #667eea;
			text-decoration: none;
			font-weight: 600;
		}
		
		.register-link a:hover {
			text-decoration: underline;
		}
		
		.error-message {
			background: #f8d7da;
			border: 1px solid #f5c6cb;
			color: #721c24;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 20px;
			font-size: 14px;
		}
		
		.success-message {
			background: #d4edda;
			border: 1px solid #c3e6cb;
			color: #155724;
			padding: 12px;
			border-radius: 6px;
			margin-bottom: 20px;
			font-size: 14px;
		}
	</style>
</head>
<body>
	<div class="login-container">
		<h1><?php echo get_option('site_name', 'DocedFrame'); ?></h1>
		<div class="subtitle">Yönetim Paneli Girişi</div>
		
		<?php if (isset($_SESSION['auth_error'])): ?>
		<div class="error-message">
			<?php echo $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?>
		</div>
		<?php endif; ?>
		
		<?php if (isset($_SESSION['auth_success'])): ?>
		<div class="success-message">
			<?php echo $_SESSION['auth_success']; unset($_SESSION['auth_success']); ?>
		</div>
		<?php endif; ?>
		
		<form method="POST" action="/df-admin/login">
			<div class="form-group">
				<label>E-posta Adresi</label>
				<input type="email" name="email" required autofocus>
			</div>
			
			<div class="form-group">
				<label>Şifre</label>
				<input type="password" name="password" required>
			</div>
			
			<div class="checkbox-group">
				<label>
					<input type="checkbox" name="remember"> Beni Hatırla
				</label>
				<a href="/sifremi-unuttum" class="forgot-link">Şifremi Unuttum?</a>
			</div>
			
			<button type="submit">Giriş Yap</button>
		</form>
		
		<div class="register-link">
			Hesabınız yok mu? <a href="/kayit">Kayıt Ol</a>
		</div>
	</div>
</body>
</html>