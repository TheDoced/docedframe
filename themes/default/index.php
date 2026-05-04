<?php include __DIR__ . '/header.php'; ?>

<!-- Hero Bölümü -->
<?php include __DIR__ . '/hero.php'; ?>

<!-- Tema Kartları Bölümü (Sadece Yazılar) -->
<section class="content-section">
	<div class="section-header">
		<div class="section-badge">ÖNE ÇIKANLAR</div>
		<h2 class="section-title">En Popüler Yazılar</h2>
		<p class="section-description">Binlerce yazı arasından size en uygun olanı seçin</p>
	</div>
	
	<div class="filter-bar">
		<div class="filter-tabs">
			<button class="filter-tab active" data-filter="all">Tümü</button>
			<button class="filter-tab" data-filter="wordpress">WordPress</button>
			<button class="filter-tab" data-filter="html">HTML/CSS</button>
			<button class="filter-tab" data-filter="react">React</button>
			<button class="filter-tab" data-filter="vue">Vue.js</button>
		</div>
		
		<div class="sort-wrapper" id="sortWrapper">
			<div class="sort-select-trigger" id="sortTrigger">
				<span id="selectedSort">En Popüler</span>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M6 9L12 15L18 9"/>
				</svg>
			</div>
			<div class="sort-dropdown">
				<div class="sort-option selected" data-value="popular">En Popüler</div>
				<div class="sort-option" data-value="price-low">Düşükten Yükseğe</div>
				<div class="sort-option" data-value="price-high">Yüksekten Düşüğe</div>
				<div class="sort-option" data-value="rating">En Yüksek Puan</div>
			</div>
		</div>
	</div>
	
	<div class="product-grid" id="productGrid">
		<?php
		$postModel = new \App\Models\Post();
		// Sadece type = 'post' olan yazıları getir
		$posts = $postModel->where('type', 'post');
		$posts = array_filter($posts, function($post) {
			return $post['status'] == 'publish';
		});
		$permalinkStructure = get_option('permalink_structure', '/yazi/%slug%');
		?>
		
		<?php if (empty($posts)): ?>
			<p>Henüz yazı bulunmuyor.</p>
		<?php else: ?>
			<?php foreach ($posts as $post): ?>
			<div class="theme-card" data-category="wordpress" data-sales="1250" data-price="49" data-rating="4.8">
				<div class="card-image">
					<img src="https://placehold.co/600x400/e2e8f0/475569?text=<?php echo urlencode($post['title']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
					<span class="card-badge hot">POPÜLER</span>
					<button class="fav-btn">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5 2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.41 22 8.5c0 3.77-3.4 6.86-8.55 11.54L12 21.35Z"/>
						</svg>
					</button>
				</div>
				<div class="card-content">
					<div class="card-title">
						<?php
						if ($permalinkStructure == 'simple') {
							$postLink = '/?p=' . $post['id'];
						} else {
							$postLink = '/yazi/' . $post['slug'];
						}
						?>
						<a href="<?php echo $postLink; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
						<div class="price">$49</div>
					</div>
					<div class="card-category">Yazı | <?php echo ucfirst($post['type']); ?></div>
					<div class="card-description"><?php echo htmlspecialchars(substr(strip_tags($post['content']), 0, 100)); ?>...</div>
					<div class="card-footer">
						<div class="card-stats">
							<div class="stat">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M12 4L12 20M20 12L4 12"/>
								</svg>
								<span>1.2K+</span>
							</div>
							<div class="rating">
								<div class="rating-stars">
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
								</div>
								<span class="rating-value">4.8</span>
							</div>
						</div>
					</div>
					<div class="card-buttons">
						<a href="#" class="btn-demo">Canlı Demo</a>
						<a href="<?php echo $postLink; ?>" class="btn-buy">İncele</a>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	
	<div class="load-more">
		<button class="load-more-btn" id="loadMoreBtn">Daha Fazla Yükle</button>
	</div>
</section>

<?php include __DIR__ . '/footer.php'; ?>