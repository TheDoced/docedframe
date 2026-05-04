<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Temalar - DocedFrame Admin</title>
	<style>
		.theme-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
			gap: 20px;
			margin-top: 20px;
		}
		.theme-card {
			border: 1px solid #ddd;
			padding: 15px;
			border-radius: 5px;
			background: #f9f9f9;
		}
		.theme-card.active {
			border: 2px solid green;
			background: #e8f5e9;
		}
		.theme-card h3 {
			margin-top: 0;
		}
		.theme-card .status {
			font-size: 12px;
			color: green;
			margin-bottom: 10px;
		}
		.theme-card button {
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<h1>Temalar</h1>
	
	<div class="theme-grid">
		<?php foreach ($themes as $theme): ?>
		<div class="theme-card <?php echo $theme['name'] == $activeTheme ? 'active' : ''; ?>">
			<h3><?php echo $theme['title']; ?></h3>
			<p><?php echo $theme['description']; ?></p>
			<p>Versiyon: <?php echo $theme['version']; ?></p>
			
			<?php if ($theme['name'] == $activeTheme): ?>
			<div class="status">✓ Aktif</div>
			<?php else: ?>
			<a href="/df-admin/themes/activate/<?php echo $theme['name']; ?>">
				<button>Aktifleştir</button>
			</a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>