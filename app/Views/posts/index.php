<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yazılar - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
</head>
<body>
	<h1><?php echo get_option('site_name', 'DocedFrame'); ?></h1>
	<h2>Yazılar</h2>
	
	<?php foreach ($posts as $post): ?>
	<div>
		<h3>
			<a href="/yazi/<?php echo $post['slug']; ?>">
				<?php echo $post['title']; ?>
			</a>
		</h3>
		<p><?php echo $post['excerpt']; ?></p>
		<small>Tarih: <?php echo $post['created_at']; ?></small>
		<hr>
	</div>
	<?php endforeach; ?>
</body>
</html>