<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Etiketler - DocedFrame Admin</title>
</head>
<body>
	<h1>Etiketler</h1>
	
	<h3>Yeni Etiket Ekle</h3>
	<form method="POST" action="/df-admin/tags/store">
		<input type="text" name="name" placeholder="Etiket adı" required>
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
			<?php foreach ($tags as $tag): ?>
			<tr>
				<td><?php echo $tag['id']; ?></td>
				<td><?php echo $tag['name']; ?></td>
				<td><?php echo $tag['slug']; ?></td>
				<td>
					<a href="/df-admin/tags/delete/<?php echo $tag['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>