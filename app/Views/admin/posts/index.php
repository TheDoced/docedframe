<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yazılar - DocedFrame Admin</title>
</head>
<body>
	<h1>Yazılar</h1>
	
	<a href="/df-admin/posts/create">+ Yeni Yazı</a>
	
	<hr>
	
	<form method="POST" action="/df-admin/posts/bulk" id="bulk-form">
		<div style="margin-bottom: 15px;">
			<select name="bulk_action" id="bulk-action">
				<option value="">Toplu İşlem Seç</option>
				<option value="delete">🗑️ Sil</option>
				<option value="draft">📝 Taslak Yap</option>
				<option value="publish">✅ Yayınla</option>
				<option value="change_category">📁 Kategori Değiştir</option>
			</select>
			
			<select name="category_id" style="display: none;" id="category-select">
				<option value="">Kategori Seç</option>
				<?php
				$termModel = new \App\Models\Term();
				$categories = $termModel->getByTaxonomy('category');
				foreach ($categories as $cat):
				?>
				<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
				<?php endforeach; ?>
			</select>
			
			<button type="submit">Uygula</button>
		</div>
		
		<?php if (isset($_SESSION['admin_message'])): ?>
		<div style="background: #d4edda; padding: 10px; margin: 10px 0;">
			<?php echo $_SESSION['admin_message']; unset($_SESSION['admin_message']); ?>
		</div>
		<?php endif; ?>
		
		<table border="1" cellpadding="10">
			<thead>
				<tr>
					<th><input type="checkbox" id="select-all"></th>
					<th>ID</th>
					<th>Başlık</th>
					<th>Tür</th>
					<th>Durum</th>
					<th>Tarih</th>
					<th>İşlemler</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($posts as $post): ?>
				<tr>
					<td><input type="checkbox" name="post_ids[]" value="<?php echo $post['id']; ?>" class="post-checkbox"></td>
					<td><?php echo $post['id']; ?></td>
					<td><?php echo $post['title']; ?></td>
					<td><?php echo $post['type']; ?></td>
					<td><?php echo $post['status']; ?></td>
					<td><?php echo $post['created_at']; ?></td>
					<td>
						<a href="/df-admin/posts/edit/<?php echo $post['id']; ?>">Düzenle</a>
						<a href="/df-admin/posts/delete/<?php echo $post['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
	
	<p><a href="/df-admin/dashboard">Dashboard</a></p>
	
	<script>
		document.getElementById('select-all')?.addEventListener('change', function(e) {
			document.querySelectorAll('.post-checkbox').forEach(cb => cb.checked = e.target.checked);
		});
		
		document.getElementById('bulk-action')?.addEventListener('change', function(e) {
			const categorySelect = document.getElementById('category-select');
			if (e.target.value === 'change_category') {
				categorySelect.style.display = 'inline';
			} else {
				categorySelect.style.display = 'none';
			}
		});
	</script>
</body>
</html>