<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yeni Kullanıcı - DocedFrame Admin</title>
</head>
<body>
	<h1>Yeni Kullanıcı Ekle</h1>
	
	<form method="POST" action="/df-admin/users/store">
		<div>
			<label>E-posta:</label><br>
			<input type="email" name="email" required>
		</div>
		<div>
			<label>Şifre:</label><br>
			<input type="password" name="password" required>
		</div>
		<div>
			<label>Ad Soyad:</label><br>
			<input type="text" name="display_name" required>
		</div>
		<div>
			<label>Rol:</label><br>
			<select name="role_id">
				<?php foreach ($roles as $role): ?>
				<option value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<button type="submit">Kaydet</button>
			<a href="/df-admin/users">İptal</a>
		</div>
	</form>
</body>
</html>