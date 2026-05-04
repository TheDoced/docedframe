<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Şifremi Unuttum - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
		.forgot-container { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); width: 100%; max-width: 420px; }
		.forgot-container h1 { text-align: center; margin-bottom: 10px; color: #333; font-size: 28px; }
		.forgot-container .subtitle { text-align: center; color: #666; margin-bottom: 30px; font-size: 14px; }
		.form-group { margin-bottom: 20px; }
		.form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
		.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
		.form-group input:focus { outline: none; border-color: #667eea; }
		button { width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
		button:hover { opacity: 0.9; }
		.back-link { text-align: center; margin-top: 20px; font-size: 14px; }
		.back-link a { color: #667eea; text-decoration: none; }
		.back-link a:hover { text-decoration: underline; }
		.error-message { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
		.success-message { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
	</style>
</head>
<body>
	<div class="forgot-container">
		<h1>Şifremi Unuttum</h1>
		<div class="subtitle">Şifre sıfırlama bağlantısı alın</div>
		
		<?php if (isset($_SESSION['auth_error'])): ?>
		<div class="error-message"><?php echo $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></div>
		<?php endif; ?>
		
		<?php if (isset($_SESSION['auth_success'])): ?>
		<div class="success-message"><?php echo $_SESSION['auth_success']; unset($_SESSION['auth_success']); ?></div>
		<?php endif; ?>
		
		<form method="POST" action="/sifremi-unuttum">
			<div class="form-group">
				<label>E-posta Adresi</label>
				<input type="email" name="email" required>
			</div>
			
			<button type="submit">Şifre Sıfırlama Bağlantısı Gönder</button>
		</form>
		
		<div class="back-link">
			<a href="/df-admin/login">← Giriş sayfasına dön</a>
		</div>
	</div>
</body>
</html>