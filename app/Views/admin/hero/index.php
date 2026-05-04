<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Hero Alanları - DocedFrame Admin</title>
</head>
<body>
	<h1>Hero Alanları</h1>
	
	<?php if (isset($_SESSION['hero_message'])): ?>
	<div style="background:#d4edda;padding:10px;margin:10px 0;">
		<?php echo $_SESSION['hero_message']; unset($_SESSION['hero_message']); ?>
	</div>
	<?php endif; ?>
	
	<a href="/df-admin/hero/create"><button>+ Yeni Hero Alanı</button></a>
	
	<hr>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>Adı</th>
				<th>Tip</th>
				<th>Durum</th>
				<th>Tarih</th>
				<th>İşlemler</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($heroSections as $hero): ?>
			<tr>
				<td><?php echo $hero['id']; ?></td>
				<td><?php echo htmlspecialchars($hero['name']); ?></td>
				<td><?php echo $hero['type'] == 'static' ? 'Statik' : 'Slider'; ?></td>
				<td><?php echo $hero['status'] == 1 ? '✅ Aktif' : '❌ Pasif'; ?></td>
				<td><?php echo $hero['created_at']; ?></td>
				<td>
					<a href="/df-admin/hero/edit/<?php echo $hero['id']; ?>">Düzenle</a>
					<?php if ($hero['status'] != 1): ?>
					<a href="/df-admin/hero/activate/<?php echo $hero['id']; ?>">Aktifleştir</a>
					<?php endif; ?>
					<a href="/df-admin/hero/delete/<?php echo $hero['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">← Dashboard</a></p>
</body>
</html>