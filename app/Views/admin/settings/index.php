<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Site Ayarları - DocedFrame Admin</title>
	<style>
		.settings-container {
			max-width: 800px;
			margin: 0 auto;
		}
		.settings-section {
			background: #fff;
			border: 1px solid #ddd;
			border-radius: 5px;
			padding: 20px;
			margin-bottom: 20px;
		}
		.settings-section h2 {
			margin-top: 0;
			border-bottom: 1px solid #eee;
			padding-bottom: 10px;
		}
		.form-group {
			margin-bottom: 15px;
		}
		.form-group label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
		}
		.form-group input, .form-group select, .form-group textarea {
			width: 100%;
			padding: 8px;
			border: 1px solid #ddd;
			border-radius: 4px;
		}
		.form-group small {
			display: block;
			color: #666;
			font-size: 12px;
			margin-top: 5px;
		}
		button {
			background: #0073aa;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
		button:hover {
			background: #005a87;
		}
		.message {
			background: #d4edda;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #c3e6cb;
			border-radius: 4px;
			color: #155724;
		}
	</style>
</head>
<body>
	<div class="settings-container">
		<h1>Site Ayarları</h1>
		
		<?php if (isset($_SESSION['settings_message'])): ?>
		<div class="message">
			<?php echo $_SESSION['settings_message']; unset($_SESSION['settings_message']); ?>
		</div>
		<?php endif; ?>
		
		<form method="POST" action="/df-admin/settings/update">
			<div class="settings-section">
				<h2>Genel Ayarlar</h2>
				
				<div class="form-group">
					<label>Site Başlığı:</label>
					<input type="text" name="site_name" value="<?php echo htmlspecialchars(get_option('site_name', 'DocedFrame')); ?>">
				</div>
				
				<div class="form-group">
					<label>Site Açıklaması:</label>
					<textarea name="site_description" rows="3"><?php echo htmlspecialchars(get_option('site_description', '')); ?></textarea>
					<small>SEO ve tarayıcılar için site açıklaması</small>
				</div>
				
				<div class="form-group">
					<label>Site URL:</label>
					<input type="url" name="site_url" value="<?php echo htmlspecialchars(get_option('site_url', 'http://docedframe.td')); ?>">
					<small>Site ana adresi, http:// ile başlamalı</small>
				</div>
			</div>
			
			<div class="settings-section">
				<h2>Yazı Ayarları</h2>
				
				<div class="form-group">
					<label>Sayfada Gösterilecek Yazı Sayısı:</label>
					<input type="number" name="posts_per_page" value="<?php echo get_option('posts_per_page', 10); ?>" min="1" max="50">
				</div>
				
				<div class="form-group">
					<label>Yorumlar:</label>
					<select name="comments_open">
						<option value="1" <?php echo get_option('comments_open', 1) == 1 ? 'selected' : ''; ?>>Açık</option>
						<option value="0" <?php echo get_option('comments_open', 1) == 0 ? 'selected' : ''; ?>>Kapalı</option>
					</select>
				</div>
				
				<div class="form-group">
					<label>Yorum Onayı:</label>
					<select name="comment_approval">
						<option value="1" <?php echo get_option('comment_approval', 1) == 1 ? 'selected' : ''; ?>>Onay gereksiz</option>
						<option value="0" <?php echo get_option('comment_approval', 1) == 0 ? 'selected' : ''; ?>>Admin onayı gerekli</option>
					</select>
				</div>
			</div>
			
			<div class="settings-section">
				<h2>Admin Panel Ayarları</h2>
				
				<div class="form-group">
					<label>Admin Panel Yolu:</label>
					<input type="text" name="admin_path" value="<?php echo htmlspecialchars(get_option('admin_path', 'df-admin')); ?>">
					<small>Güvenlik için değiştirebilirsiniz. Örn: "yonetim"</small>
				</div>
			</div>
			
			<button type="submit">Ayarları Kaydet</button>
			<a href="/df-admin/dashboard">İptal</a>
		</form>
		
		<hr>
		
		<p><a href="/df-admin/settings/permalink">🔗 Permalink (URL) Ayarları →</a></p>
		<p><a href="/">🌐 Siteyi Görüntüle</a></p>
	</div>
</body>
</html>