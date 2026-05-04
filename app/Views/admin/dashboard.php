<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Dashboard - DocedFrame Admin</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background: #f1f1f1;
		}
		.admin-container {
			display: flex;
		}
		.admin-sidebar {
			width: 250px;
			background: #23282d;
			color: #fff;
			min-height: 100vh;
		}
		.admin-sidebar h2 {
			padding: 20px;
			margin: 0;
			text-align: center;
			border-bottom: 1px solid #333;
		}
		.admin-sidebar ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.admin-sidebar li {
			border-bottom: 1px solid #333;
		}
		.admin-sidebar li a {
			display: block;
			padding: 12px 20px;
			color: #fff;
			text-decoration: none;
		}
		.admin-sidebar li a:hover {
			background: #0073aa;
		}
		.admin-content {
			flex: 1;
			padding: 20px;
		}
		.admin-header {
			background: #fff;
			padding: 15px 20px;
			margin-bottom: 20px;
			border-radius: 5px;
			box-shadow: 0 1px 3px rgba(0,0,0,0.1);
		}
		.admin-header h1 {
			margin: 0;
			font-size: 24px;
		}
		.user-info {
			float: right;
			margin-top: -30px;
		}
		.logout-btn {
			background: #d9534f;
			color: #fff;
			padding: 5px 10px;
			text-decoration: none;
			border-radius: 3px;
		}
		.logout-btn:hover {
			background: #c9302c;
		}
	</style>
</head>
<body>
<div class="admin-container">
	<div class="admin-sidebar">
		<h2>DocedFrame</h2>
		<ul>
			<li><a href="/df-admin/dashboard">📊 Dashboard</a></li>
			
			<?php if (current_user_can('edit_posts')): ?>
			<li><a href="/df-admin/posts">📝 Yazılar</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('manage_categories')): ?>
			<li><a href="/df-admin/categories">🏷️ Kategoriler</a></li>
			<li><a href="/df-admin/tags">🔖 Etiketler</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('upload_files')): ?>
			<li><a href="/df-admin/media">🖼️ Medya</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('manage_users')): ?>
			<li><a href="/df-admin/users">👥 Kullanıcılar</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('moderate_comments')): ?>
			<li><a href="/df-admin/comments">💬 Yorumlar</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('manage_themes')): ?>
			<li><a href="/df-admin/themes">🎨 Temalar</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('manage_plugins')): ?>
			<li><a href="/df-admin/plugins">🔌 Eklentiler</a></li>
			<?php endif; ?>
			
			<?php if (current_user_can('manage_options')): ?>
			<li><a href="/df-admin/seo">🔍 SEO Ayarları</a></li>
			<li><a href="/df-admin/backup">💾 Yedekleme</a></li>
			<li><a href="/df-admin/cache">⚡ Cache Yönetimi</a></li>
			<li><a href="/df-admin/settings">⚙️ Ayarlar</a></li>
			<li><a href="/df-admin/menus">📋 Menü Yöneticisi</a></li>
			<li><a href="/df-admin/hero">🎯 Hero Alanları</a></li>
			<li><a href="/df-admin/settings">⚙️ Site Ayarları</a></li>
			<?php endif; ?>
			
			<li><a href="/">🌐 Siteyi Görüntüle</a></li>
		</ul>
	</div>
	
	<div class="admin-content">
		<div class="admin-header">
			<h1>Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></h1>
			<div class="user-info">
				<a href="/df-admin/logout" class="logout-btn">Çıkış Yap</a>
			</div>
		</div>
		
		<div class="dashboard-widgets">
			<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
				<div style="background: #fff; padding: 20px; border-radius: 5px;">
					<h3>📝 Toplam Yazı</h3>
					<p style="font-size: 30px;"><?php echo $totalPosts ?? 0; ?></p>
				</div>
				<div style="background: #fff; padding: 20px; border-radius: 5px;">
					<h3>📄 Toplam Sayfa</h3>
					<p style="font-size: 30px;"><?php echo $totalPages ?? 0; ?></p>
				</div>
				<div style="background: #fff; padding: 20px; border-radius: 5px;">
					<h3>👥 Toplam Kullanıcı</h3>
					<p style="font-size: 30px;"><?php echo $totalUsers ?? 0; ?></p>
				</div>
				<div style="background: #fff; padding: 20px; border-radius: 5px;">
					<h3>💬 Toplam Yorum</h3>
					<p style="font-size: 30px;"><?php echo $totalComments ?? 0; ?></p>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>