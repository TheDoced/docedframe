<?php
$commentsOpen = get_option('comments_open', '1');
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title><?php echo $post['title']; ?> - <?php echo get_option('site_name', 'DocedFrame'); ?></title>
</head>
<body>
	<h1><?php echo get_option('site_name', 'DocedFrame'); ?></h1>
	
	<article>
		<h2><?php echo $post['title']; ?></h2>
		<small>Tarih: <?php echo $post['created_at']; ?></small>
		<div>
			<?php echo nl2br($post['content']); ?>
		</div>
	</article>
	
	<?php if ($commentsOpen == '1'): ?>
	<hr>
	<h3>Yorumlar (<?php echo count($comments); ?>)</h3>
	
	<div class="comments">
		<?php foreach ($comments as $comment): ?>
		<div style="border-bottom: 1px solid #ddd; margin-bottom: 10px; padding-bottom: 10px;">
			<strong><?php echo htmlspecialchars($comment['author_name']); ?></strong>
			<small><?php echo $comment['created_at']; ?></small>
			<p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
		</div>
		<?php endforeach; ?>
	</div>
	
	<h3>Yorum Yap</h3>
	<form method="POST" action="/yorum-ekle">
		<input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
		<input type="hidden" name="post_slug" value="<?php echo $post['slug']; ?>">
		
		<div>
			<label>Adınız:</label><br>
			<input type="text" name="author_name" required>
		</div>
		<div>
			<label>E-posta:</label><br>
			<input type="email" name="author_email" required>
		</div>
		<div>
			<label>Yorumunuz:</label><br>
			<textarea name="content" rows="5" cols="50" required></textarea>
		</div>
		<div>
			<button type="submit">Yorum Gönder</button>
		</div>
	</form>
	<?php else: ?>
	<p><em>Yorumlar kapalıdır.</em></p>
	<?php endif; ?>
	
	<p><a href="/">Ana Sayfa</a></p>
</body>
</html>