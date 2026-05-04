<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yazı Düzenle - DocedFrame Admin</title>
</head>
<body>
	<h1>Yazı Düzenle</h1>
	
	<form method="POST" action="/df-admin/posts/update/<?php echo $post['id']; ?>">
		<div>
			<label>Başlık:</label><br>
			<input type="text" name="title" value="<?php echo $post['title']; ?>" required style="width: 100%;">
		</div>
		<div>
			<label>Tür:</label><br>
			<select name="type">
				<option value="post" <?php echo $post['type'] == 'post' ? 'selected' : ''; ?>>Yazı</option>
				<option value="page" <?php echo $post['type'] == 'page' ? 'selected' : ''; ?>>Sayfa</option>
			</select>
		</div>
		<div>
			<label>Durum:</label><br>
			<select name="status">
				<option value="draft" <?php echo $post['status'] == 'draft' ? 'selected' : ''; ?>>Taslak</option>
				<option value="publish" <?php echo $post['status'] == 'publish' ? 'selected' : ''; ?>>Yayınla</option>
			</select>
		</div>
		<div>
			<label>İçerik:</label><br>
			<textarea name="content" rows="15" style="width: 100%;"><?php echo $post['content']; ?></textarea>
		</div>
		<div>
			<button type="submit">Güncelle</button>
			<a href="/df-admin/posts">İptal</a>
		</div>
	</form>
</body>
</html>