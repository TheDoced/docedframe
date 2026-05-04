<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Kullanıcılar - DocedFrame Admin</title>
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
		}
		th, td {
			padding: 10px;
			border: 1px solid #ddd;
			text-align: left;
		}
		th {
			background: #f5f5f5;
		}
	</style>
</head>
<body>
	<h1>Kullanıcılar</h1>
	
	<a href="/df-admin/users/create">+ Yeni Kullanıcı</a>
	
	<hr>
	
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>E-posta</th>
				<th>Ad Soyad</th>
				<th>Roller</th>
				<th>Durum</th>
				<th>Kayıt Tarihi</th>
				<th>İşlemler</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['display_name']; ?></td>
				<td>
					<?php 
					$roleNames = [];
					foreach ($user['roles'] as $role) {
						$roleNames[] = $role['name'];
					}
					echo implode(', ', $roleNames);
					?>
				</td>
				<td><?php echo $user['status'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
				<td><?php echo $user['created_at']; ?></td>
				<td>
					<a href="/df-admin/users/edit/<?php echo $user['id']; ?>">Düzenle</a>
					<?php if ($user['id'] != 1): ?>
					<a href="/df-admin/users/delete/<?php echo $user['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>