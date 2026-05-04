<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yedekleme - DocedFrame Admin</title>
</head>
<body>
	<h1>Yedekleme Sistemi</h1>
	
	<?php if (isset($_SESSION['backup_message'])): ?>
	<div style="background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; margin: 10px 0;">
		<?php echo htmlspecialchars($_SESSION['backup_message']); unset($_SESSION['backup_message']); ?>
	</div>
	<?php endif; ?>
	
	<div style="margin-bottom: 20px;">
		<a href="/df-admin/backup/create">
			<button style="background: green; color: white; padding: 10px;">+ Yeni Yedek Oluştur</button>
		</a>
	</div>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>Dosya Adı</th>
				<th>Boyut</th>
				<th>Tarih</th>
				<th>İşlemler</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($backups)): ?>
			<tr>
				<td colspan="4">Henüz yedek yok.</td>
			</tr>
			<?php else: ?>
				<?php foreach ($backups as $backup): ?>
				<tr>
					<td><?php echo $backup['name']; ?></td>
					<td><?php echo $backup['size']; ?></td>
					<td><?php echo $backup['date']; ?></td>
					<td>
						<a href="/df-admin/backup/download/<?php echo $backup['name']; ?>">İndir</a>
						<a href="/df-admin/backup/restore/<?php echo $backup['name']; ?>" onclick="return confirm('Geri yüklemek istediğinize emin misiniz?')">Geri Yükle</a>
						<a href="/df-admin/backup/delete/<?php echo $backup['name']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>