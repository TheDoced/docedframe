<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yeni Yazı - DocedFrame Admin</title>
</head>
<body>
	<h1>Yeni Yazı Ekle</h1>
	
	<form method="POST" action="/df-admin/posts/store">
		<div>
			<label>Başlık:</label><br>
			<input type="text" name="title" required style="width: 100%;">
		</div>
		
		<div>
			<label>Kategoriler:</label><br>
			<select name="categories[]" multiple>
				<?php foreach ($categories as $cat): ?>
				<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div>
			<label>Etiketler:</label><br>
			<select name="tags[]" multiple>
				<?php foreach ($tags as $tag): ?>
				<option value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<div>
			<label>Tür:</label><br>
			<select name="type">
				<option value="post">Yazı</option>
				<option value="page">Sayfa</option>
			</select>
		</div>
		
		<div>
			<label>Durum:</label><br>
			<select name="status">
				<option value="draft">Taslak</option>
				<option value="publish">Yayınla</option>
			</select>
		</div>
		
		<div>
			<label>İçerik:</label><br>
			<textarea name="content" rows="15" style="width: 100%;"></textarea>
		</div>
		
		<div>
			<button type="submit">Kaydet</button>
			<a href="/df-admin/posts">İptal</a>
		</div>
	</form>
</body>
</html>