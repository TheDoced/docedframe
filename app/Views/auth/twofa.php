<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>İki Adımlı Doğrulama - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
		.twofa-container { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); width: 100%; max-width: 420px; }
		.twofa-container h1 { text-align: center; margin-bottom: 10px; color: #333; font-size: 28px; }
		.twofa-container .subtitle { text-align: center; color: #666; margin-bottom: 30px; font-size: 14px; }
		.form-group { margin-bottom: 20px; }
		.form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
		.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; text-align: center; letter-spacing: 4px; }
		.form-group input:focus { outline: none; border-color: #667eea; }
		button { width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
		button:hover { opacity: 0.9; }
		.error-message { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
		.info-text { text-align: center; font-size: 13px; color: #666; margin-top: 15px; }
	</style>
</head>
<body>
	<div class="twofa-container">
		<h1>İki Adımlı Doğrulama</h1>
		<div class="subtitle">Google Authenticator kodunuzu girin</div>
		
		<?php if (isset($_SESSION['auth_error'])): ?>
		<div class="error-message"><?php echo $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></div>
		<?php endif; ?>
		
		<form method="POST" action="/df-admin/2fa/verify">
			<div class="form-group">
				<label>6 Haneli Kod</label>
				<input type="text" name="code" maxlength="6" required placeholder="000000">
			</div>
			
			<button type="submit">Doğrula</button>
		</form>
		
		<div class="info-text">
			Google Authenticator uygulamasından 6 haneli kodu girin.
		</div>
	</div>
</body>
</html>
