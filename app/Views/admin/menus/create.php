<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yeni Menü - DocedFrame Admin</title>
</head>
<body>
	<h1>Yeni Menü Oluştur</h1>
	
	<form method="POST" action="/df-admin/menus/store">
		<div style="margin-bottom:15px;">
			<label>Menü Adı:</label><br>
			<input type="text" name="name" required style="width:100%;max-width:400px;padding:8px;">
		</div>
		
		<div style="margin-bottom:15px;">
			<label>Konum:</label><br>
			<select name="location" style="width:100%;max-width:400px;padding:8px;">
				<option value="">Seçin...</option>
				<option value="primary">Ana Menü (primary)</option>
				<option value="footer">Alt Menü (footer)</option>
				<option value="sidebar">Yan Menü (sidebar)</option>
			</select>
		</div>
		
		<button type="submit">Menü Oluştur</button>
		<a href="/df-admin/menus">İptal</a>
	</form>
	
	<p><a href="/df-admin/menus">← Menülere Dön</a></p>
</body>
</html>