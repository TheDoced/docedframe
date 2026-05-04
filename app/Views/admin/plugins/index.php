<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Eklentiler - DocedFrame Admin</title>
	<style>
		.plugin-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
			gap: 20px;
			margin-top: 20px;
		}
		.plugin-card {
			border: 1px solid #ddd;
			padding: 15px;
			border-radius: 5px;
			background: #f9f9f9;
		}
		.plugin-card.active {
			border: 2px solid green;
			background: #e8f5e9;
		}
		.plugin-card h3 {
			margin-top: 0;
		}
		.plugin-card .status {
			font-size: 12px;
			margin-bottom: 10px;
		}
		.plugin-card .status.active {
			color: green;
		}
		.plugin-card .status.inactive {
			color: red;
		}
	</style>
</head>
<body>
	<h1>Eklentiler</h1>
	
	<div class="plugin-grid">
		<?php foreach ($plugins as $plugin): ?>
		<?php $isActive = in_array($plugin['name'], $activePlugins); ?>
		<div class="plugin-card <?php echo $isActive ? 'active' : ''; ?>">
			<h3><?php echo $plugin['title']; ?></h3>
			<p><?php echo $plugin['description']; ?></p>
			<p>Versiyon: <?php echo $plugin['version']; ?> | Yazar: <?php echo $plugin['author']; ?></p>
			
			<?php if ($isActive): ?>
			<div class="status active">✓ Aktif</div>
			<a href="/df-admin/plugins/deactivate/<?php echo $plugin['name']; ?>">
				<button>Devre Dışı Bırak</button>
			</a>
			<?php else: ?>
			<div class="status inactive">✗ Pasif</div>
			<a href="/df-admin/plugins/activate/<?php echo $plugin['name']; ?>">
				<button>Aktifleştir</button>
			</a>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>