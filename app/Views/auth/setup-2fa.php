<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>2FA Kurulumu - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
		.setup-container { background: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 15px 35px rgba(0,0,0,0.2); width: 100%; max-width: 500px; }
		.setup-container h1 { text-align: center; margin-bottom: 10px; color: #333; font-size: 28px; }
		.setup-container .subtitle { text-align: center; color: #666; margin-bottom: 30px; font-size: 14px; }
		.qr-code { text-align: center; margin-bottom: 20px; }
		.qr-code img { border: 1px solid #ddd; padding: 10px; background: #fff; border-radius: 8px; }
		.secret-key { background: #f5f5f5; padding: 12px; border-radius: 6px; text-align: center; margin-bottom: 20px; }
		.secret-key code { font-size: 18px; letter-spacing: 2px; background: #333; color: #fff; padding: 8px 15px; border-radius: 4px; display: inline-block; }
		.form-group { margin-bottom: 20px; }
		.form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; font-size: 14px; }
		.form-group input { width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; text-align: center; letter-spacing: 4px; }
		button { width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 12px; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
		button:hover { opacity: 0.9; }
		.error-message { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; }
		.info-text { text-align: center; font-size: 13px; color: #666; margin-top: 15px; line-height: 1.5; }
	</style>
</head>
<body>
	<div class="setup-container">
		<h1>İki Adımlı Doğrulama Kurulumu</h1>
		<div class="subtitle">Hesabınızı daha güvenli hale getirin</div>
		
		<?php if (isset($_SESSION['auth_error'])): ?>
		<div class="error-message"><?php echo $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></div>
		<?php endif; ?>
		
		<div class="qr-code">
			<img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
		</div>
		
		<div class="secret-key">
			<code><?php echo $secret; ?></code>
		</div>
		
		<div class="info-text">
			1. Google Authenticator uygulamasını indirin<br>
			2. QR kodu taratın veya kodu manuel girin<br>
			3. Aşağıdaki kodu girerek doğrulayın
		</div>
		
		<form method="POST" action="/df-admin/2fa/enable">
			<div class="form-group">
				<label>Doğrulama Kodu</label>
				<input type="text" name="code" maxlength="6" required placeholder="000000">
			</div>
			
			<button type="submit">2FA'yı Etkinleştir</button>
		</form>
	</div>
</body>
</html>