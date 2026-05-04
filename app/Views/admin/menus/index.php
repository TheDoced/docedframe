<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Menüler - DocedFrame Admin</title>
</head>
<body>
	<h1>Menüler</h1>
	
	<?php if (isset($_SESSION['menu_message'])): ?>
	<div style="background:#d4edda;padding:10px;margin:10px 0;">
		<?php echo $_SESSION['menu_message']; unset($_SESSION['menu_message']); ?>
	</div>
	<?php endif; ?>
	
	<a href="/df-admin/menus/create"><button>+ Yeni Menü</button></a>
	
	<hr>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>Menü Adı</th>
				<th>Konum</th>
				<th>Tarih</th>
				<th>İşlemler</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($menus)): ?>
			<tr>
				<td colspan="5" style="text-align:center;">Henüz menü yok. Yeni menü oluşturun.</td>
			</tr>
			<?php else: ?>
				<?php foreach ($menus as $menu): ?>
				<tr>
					<td><?php echo $menu['id']; ?></td>
					<td><?php echo htmlspecialchars($menu['name']); ?></td>
					<td><?php echo $menu['location'] ?: '-'; ?></td>
					<td><?php echo $menu['created_at']; ?></td>
					<td>
						<a href="/df-admin/menus/edit/<?php echo $menu['id']; ?>">Düzenle</a>
						<a href="/df-admin/menus/delete/<?php echo $menu['id']; ?>" onclick="return confirm('Menü silinsin mi?')" style="color:red;">Sil</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">← Dashboard</a></p>
</body>
</html>