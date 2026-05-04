<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Permalink Ayarları - DocedFrame Admin</title>
	<style>
		.container { max-width: 800px; margin: 0 auto; }
		.section { background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 20px; margin-bottom: 20px; }
		.section h2 { margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; }
		.permalink-option { margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 4px; }
		.permalink-option label { font-weight: bold; }
		.permalink-option code { display: block; margin-top: 5px; color: #666; }
		input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
		button { background: #0073aa; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
		button:hover { background: #005a87; }
		.message { background: #d4edda; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; }
		.warning { background: #fff3cd; padding: 15px; margin-bottom: 20px; border: 1px solid #ffeeba; border-radius: 4px; color: #856404; }
		.current-structure { background: #e7f3ff; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
	</style>
</head>
<body>
	<div class="container">
		<h1>Permalink (URL) Ayarları</h1>
		
		<?php if (isset($_SESSION['settings_message'])): ?>
		<div class="message">
			<?php echo $_SESSION['settings_message']; unset($_SESSION['settings_message']); ?>
		</div>
		<?php endif; ?>
		
		<?php
		$categoryCount = 0;
		try {
			$pdo = \Core\Database\Connection::getInstance()->getPdo();
			$stmt = $pdo->query("SELECT COUNT(*) FROM terms WHERE taxonomy = 'category'");
			$categoryCount = $stmt->fetchColumn();
		} catch (Exception $e) {
			$categoryCount = 0;
		}
		
		$currentPermalink = get_option('permalink_structure', 'simple');
		
		if ($currentPermalink == '/%category%/%slug%' && $categoryCount == 0):
		?>
		<div class="warning">
			⚠️ <strong>Uyarı:</strong> Kategori bazlı permalink seçtiniz ancak henüz hiç 
			<a href="/df-admin/categories">kategori oluşturulmamış</a>. 
			Kategori oluşturmadan bu permalink yapısı çalışmayacaktır. 
			Önce <a href="/df-admin/categories">kategoriler</a> oluşturun.
		</div>
		<?php endif; ?>
		
		<div class="current-structure">
			<strong>Mevcut URL Yapısı:</strong><br>
			<code><?php echo htmlspecialchars($currentPermalink); ?></code>
		</div>
		
		<form method="POST" action="/df-admin/settings/update-permalink">
			<div class="section">
				<h2>URL Yapısı Seçenekleri</h2>
				
				<div class="permalink-option">
					<label>
						<input type="radio" name="permalink_structure" value="simple" <?php echo $currentPermalink == 'simple' ? 'checked' : ''; ?>>
						Basit - ?p=123
					</label>
					<code><?php echo get_option('site_url', 'http://docedframe.td'); ?>/?p=123</code>
				</div>
				
				<div class="permalink-option">
					<label>
						<input type="radio" name="permalink_structure" value="/yazi/%slug%" <?php echo $currentPermalink == '/yazi/%slug%' ? 'checked' : ''; ?>>
						Sade - /yazi/yazi-adi
					</label>
					<code><?php echo get_option('site_url', 'http://docedframe.td'); ?>/yazi/ornek-yazi</code>
				</div>
				
				<div class="permalink-option">
					<label>
						<input type="radio" name="permalink_structure" value="/%year%/%month%/%slug%" <?php echo $currentPermalink == '/%year%/%month%/%slug%' ? 'checked' : ''; ?>>
						Tarih Bazlı - /2026/05/yazi-adi
					</label>
					<code><?php echo get_option('site_url', 'http://docedframe.td'); ?>/2026/05/ornek-yazi</code>
				</div>
				
				<div class="permalink-option <?php echo $categoryCount == 0 ? 'disabled' : ''; ?>">
					<label>
						<input type="radio" name="permalink_structure" value="/%category%/%slug%" <?php echo $currentPermalink == '/%category%/%slug%' ? 'checked' : ''; ?> <?php echo $categoryCount == 0 ? 'disabled' : ''; ?>>
						Kategori Bazlı - /kategori/yazi-adi
					</label>
					<code><?php echo get_option('site_url', 'http://docedframe.td'); ?>/teknoloji/ornek-yazi</code>
					<?php if ($categoryCount == 0): ?>
					<small style="color:red;">⚠️ Önce kategori oluşturmalısınız</small>
					<?php endif; ?>
				</div>
				
				<div class="permalink-option">
					<label>
						<input type="radio" name="permalink_structure" value="custom" <?php echo strpos($currentPermalink, '%') !== false && $currentPermalink != '/yazi/%slug%' && $currentPermalink != '/%year%/%month%/%slug%' && $currentPermalink != '/%category%/%slug%' && $currentPermalink != 'simple' ? 'checked' : ''; ?>>
						Özel Yapı
					</label>
					<input type="text" name="custom_structure" value="<?php echo htmlspecialchars($currentPermalink); ?>" placeholder="/%id%-%slug%/">
					<small>Kullanılabilir etiketler: %year%, %month%, %day%, %slug%, %category%, %id%</small>
					<br>
					<small>Örnek: <code>/post/%id%/%slug%</code> → <code>/post/1/shortcode-test</code></small>
				</div>
			</div>
			
			<div class="section">
				<h2>Kategori ve Etiket Temel URL</h2>
				
				<div class="permalink-option">
					<label>Kategori URL Öneki:</label>
					<input type="text" name="category_base" value="<?php echo htmlspecialchars(get_option('category_base', 'kategori')); ?>" placeholder="kategori">
					<small>Örn: kategori, kategoriler, cat</small>
				</div>
				
				<div class="permalink-option">
					<label>Etiket URL Öneki:</label>
					<input type="text" name="tag_base" value="<?php echo htmlspecialchars(get_option('tag_base', 'etiket')); ?>" placeholder="etiket">
					<small>Örn: etiket, tag, konu</small>
				</div>
			</div>
			
			<button type="submit">Değişiklikleri Kaydet</button>
			<a href="/df-admin/settings">← Geri</a>
		</form>
		
		<hr>
		
		<p><strong>Not:</strong> Permalink yapısını değiştirdikten sonra .htaccess dosyasının yazılabilir olduğundan emin olun.</p>
	</div>
</body>
</html>