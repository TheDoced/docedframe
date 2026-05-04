<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Admin Giriş - DocedFrame</title>
</head>
<body>
	<h2>DocedFrame Yönetim Paneli</h2>
	<h3>Giriş Yap</h3>
	
	<form method="POST" action="/df-admin/login">
		<div>
			<label>E-posta:</label><br>
			<input type="email" name="email" required>
		</div>
		<div>
			<label>Şifre:</label><br>
			<input type="password" name="password" required>
		</div>
		<div>
			<button type="submit">Giriş Yap</button>
		</div>
	</form>
</body>
</html>