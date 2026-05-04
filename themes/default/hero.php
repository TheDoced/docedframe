<?php
// Hero aktif mi kontrol et
$heroModel = new \App\Models\Hero();
$hero = $heroModel->getActive();

// Hero yoksa varsayılan göster
if (!$hero) {
	$hero = [
		'type' => 'static',
		'badge_text' => '✨ Tema Satış Platformu',
		'title' => 'Modern Tema ve Şablonları Keşfedin',
		'subtitle' => '10.000+ kaliteli tema, şablon ve dijital ürün. İhtiyacınız olanı bulun.',
		'button_text' => 'Keşfet',
		'button_url' => '/arama',
		'search_placeholder' => 'Tema, şablon veya kategori ara...'
	];
}
?>

<section class="hero-modern">
	<div class="hero-modern-container">
		<div class="hero-modern-content">
			<!-- Badge -->
			<div class="hero-modern-badge">
				<span>✨</span>
				<?php echo htmlspecialchars($hero['badge_text'] ?? 'Tema Satış Platformu'); ?>
			</div>
			
			<!-- Başlık -->
			<h1 class="hero-modern-title">
				<?php echo htmlspecialchars($hero['title']); ?>
			</h1>
			
			<!-- Açıklama -->
			<p class="hero-modern-description">
				<?php echo htmlspecialchars($hero['subtitle']); ?>
			</p>
			
			<?php if ($hero['type'] == 'search'): ?>
			<!-- Arama Bölümü -->
			<div class="hero-modern-search">
				<div class="search-modern-wrapper">
					<div class="search-modern-category">
						<div class="category-select-modern" id="heroCategorySelect">
							<div class="category-select-trigger">
								<span id="heroSelectedCategory">Tüm Kategoriler</span>
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<path d="M6 9L12 15L18 9"/>
								</svg>
							</div>
							<div class="category-select-dropdown">
								<div class="category-option selected" data-value="all">Tüm Kategoriler</div>
								<div class="category-option" data-value="wordpress">WordPress</div>
								<div class="category-option" data-value="html">HTML/CSS</div>
								<div class="category-option" data-value="react">React</div>
								<div class="category-option" data-value="vue">Vue.js</div>
								<div class="category-option" data-value="ecommerce">E-Ticaret</div>
							</div>
							<input type="hidden" id="heroCategoryInput" value="all">
						</div>
					</div>
					
					<div class="search-modern-input">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"/>
						</svg>
						<input type="text" id="heroSearchInput" placeholder="<?php echo htmlspecialchars($hero['search_placeholder'] ?? 'Tema, şablon veya kategori ara...'); ?>">
					</div>
					
					<button class="search-modern-btn" id="heroSearchBtn">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 12H19M19 12L12 5M19 12L12 19"/>
						</svg>
						Ara
					</button>
				</div>
				
				<!-- AJAX Sonuçları -->
				<div class="hero-search-results" id="heroSearchResults" style="display: none;">
					<div class="results-header" id="resultsHeader">
						<span id="resultsCount">0</span> sonuç bulundu
					</div>
					<div class="results-list" id="resultsList"></div>
					<div class="results-footer" id="resultsFooter" style="display: none;">
						<button class="show-all-results" id="showAllResultsBtn">Tüm Sonuçları Göster</button>
					</div>
				</div>
			</div>
			
			<!-- Popüler Etiketler -->
			<div class="hero-modern-tags">
				<span class="tags-label">Popüler:</span>
				<div class="tags-list">
					<a href="#" class="tag-link" data-tag="wordpress">WordPress</a>
					<a href="#" class="tag-link" data-tag="ecommerce">E-Ticaret</a>
					<a href="#" class="tag-link" data-tag="admin">Admin Panel</a>
					<a href="#" class="tag-link" data-tag="portfolio">Portfolio</a>
					<a href="#" class="tag-link" data-tag="responsive">Mobil Uyumlu</a>
				</div>
			</div>
			<?php else: ?>
			<!-- Statik Hero Butonu -->
			<?php if (!empty($hero['button_text'])): ?>
			<a href="<?php echo $hero['button_url']; ?>" class="hero-modern-btn">
				<?php echo htmlspecialchars($hero['button_text']); ?>
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<path d="M5 12H19M19 12L12 5M19 12L12 19"/>
				</svg>
			</a>
			<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</section>