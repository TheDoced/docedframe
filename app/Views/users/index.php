<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Kullanıcılar - DocedFrame</title>
</head>
<body>
	<h1>Kullanıcı Listesi</h1>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>E-posta</th>
				<th>Ad Soyad</th>
				<th>Durum</th>
				<th>Kayıt Tarihi</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['display_name']; ?></td>
				<td><?php echo $user['status'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
				<td><?php echo $user['created_at']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>