<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Cache Yönetimi - DocedFrame Admin</title>
</head>
<body>
	<h1>Cache Yönetimi</h1>
	
	<?php if (isset($_SESSION['cache_message'])): ?>
	<div style="background: #d4edda; padding: 10px; margin: 10px 0;">
		<?php echo htmlspecialchars($_SESSION['cache_message']); unset($_SESSION['cache_message']); ?>
	</div>
	<?php endif; ?>
	
	<div style="background: #f5f5f5; padding: 20px; border-radius: 5px;">
		<h3>Cache Bilgileri</h3>
		<p>Cache sistemi dosya tabanlıdır.</p>
		<p>Cache klasörü: <code>/storage/cache/</code></p>
		
		<hr>
		
		<a href="/df-admin/cache/clear" onclick="return confirm('Tüm cache temizlensin mi?')">
			<button style="background: #d9534f; color: white; padding: 10px;">🗑️ Tüm Cache'i Temizle</button>
		</a>
	</div>
	
	<p><a href="/df-admin/dashboard">← Dashboard</a></p>
</body>
</html>