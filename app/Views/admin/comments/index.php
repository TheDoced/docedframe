<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yorumlar - DocedFrame Admin</title>
</head>
<body>
	<h1>Yorumlar</h1>
	
	<table border="1" cellpadding="10">
		<thead>
			<tr>
				<th>ID</th>
				<th>Yazı</th>
				<th>Yorum Yapan</th>
				<th>Yorum</th>
				<th>Durum</th>
				<th>Tarih</th>
				<th>İşlemler</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($comments as $comment): ?>
			<tr>
				<td><?php echo $comment['id']; ?></td>
				<td><?php echo $comment['post_title']; ?></td>
				<td><?php echo htmlspecialchars($comment['author_name']); ?><br>
					<small><?php echo $comment['author_email']; ?></small>
				</td>
				<td><?php echo nl2br(htmlspecialchars(substr($comment['content'], 0, 100))); ?>...</td>
				<td><?php echo $comment['status']; ?></td>
				<td><?php echo $comment['created_at']; ?></td>
				<td>
					<?php if ($comment['status'] == 'pending'): ?>
					<a href="/df-admin/comments/approve/<?php echo $comment['id']; ?>">Onayla</a>
					<?php endif; ?>
					<a href="/df-admin/comments/delete/<?php echo $comment['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
</body>
</html>