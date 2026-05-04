<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Medya Yöneticisi - DocedFrame Admin</title>
	<style>
		.media-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
			gap: 20px;
			margin-top: 20px;
		}
		.media-item {
			border: 1px solid #ddd;
			padding: 10px;
			text-align: center;
		}
		.media-item img {
			max-width: 100%;
			height: auto;
			max-height: 120px;
		}
		.media-item .filename {
			font-size: 12px;
			margin-top: 5px;
			word-break: break-all;
		}
		.media-item .delete {
			margin-top: 5px;
		}
		.upload-form {
			margin-bottom: 20px;
			padding: 15px;
			border: 1px solid #ccc;
			background: #f9f9f9;
		}
	</style>
</head>
<body>
	<h1>Medya Yöneticisi</h1>
	
	<div class="upload-form">
		<h3>Dosya Yükle</h3>
		<form method="POST" action="/df-admin/media/upload" enctype="multipart/form-data">
			<input type="file" name="file" required>
			<button type="submit">Yükle</button>
		</form>
	</div>
	
	<div class="media-grid">
		<?php foreach ($mediaFiles as $file): ?>
		<div class="media-item">
			<?php if (strpos($file['mime_type'], 'image/') === 0): ?>
				<img src="<?php echo $file['path']; ?>" alt="<?php echo htmlspecialchars($file['original_name']); ?>">
			<?php else: ?>
				<div>📄 <?php echo $file['original_name']; ?></div>
			<?php endif; ?>
			<div class="filename"><?php echo $file['original_name']; ?></div>
			<div class="delete">
				<a href="/df-admin/media/delete/<?php echo $file['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>