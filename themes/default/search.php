<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Arama Sonuçları - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
	<link rel="stylesheet" href="/themes/default/assets/css/style.css">
</head>
<body>
	<header>
		<div class="container">
			<h1><?php echo get_option('site_name', 'DocedFrame'); ?></h1>
			<?php include __DIR__ . '/search-form.php'; ?>
		</div>
	</header>
	
	<div class="container">
		<main>
			<h2>Arama Sonuçları: "<?php echo htmlspecialchars($keyword); ?>"</h2>
			
			<?php if (empty($keyword)): ?>
				<p>Lütfen bir arama kelimesi girin.</p>
			<?php elseif (empty($results)): ?>
				<p>"<?php echo htmlspecialchars($keyword); ?>" için sonuç bulunamadı.</p>
			<?php else: ?>
				<p><?php echo count($results); ?> sonuç bulundu.</p>
				
				<?php foreach ($results as $post): ?>
				<article>
					<h3>
						<a href="/yazi/<?php echo $post['slug']; ?>">
							<?php echo htmlspecialchars($post['title']); ?>
						</a>
					</h3>
					<small>Tarih: <?php echo $post['created_at']; ?></small>
					<p><?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 200)); ?>...</p>
				</article>
				<?php endforeach; ?>
			<?php endif; ?>
		</main>
	</div>
	
	<footer>
		<div class="container">
			<p>&copy; <?php echo date('Y'); ?> <?php echo get_option('site_name', 'DocedFrame'); ?></p>
		</div>
	</footer>
</body>
</html>