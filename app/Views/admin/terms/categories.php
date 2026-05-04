<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Kategoriler - DocedFrame Admin</title>
</head>
<body>
	<h1>Kategoriler</h1>
	
	<h3>Yeni Kategori Ekle</h3>
	<form method="POST" action="/df-admin/categories/store">
		<input type="text" name="name" placeholder="Kategori adı" required>
		<button type="submit">Ekle</button>
	</form>
	
	<hr>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>Ad</th>
				<th>Slug</th>
				<th>İşlem</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categories as $category): ?>
			<tr>
				<td><?php echo $category['id']; ?></td>
				<td><?php echo $category['name']; ?></td>
				<td><?php echo $category['slug']; ?></td>
				<td>
					<a href="/df-admin/categories/delete/<?php echo $category['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>