<footer class="footer">
	<div class="footer-container">
		<div class="footer-grid">
			<!-- Logo & About -->
			<div class="footer-col">
				<h3><?php echo get_option('site_name', 'DocedFrame'); ?></h3>
				<p>Modern web projeleri için profesyonel tema ve şablon platformu. Binlerce tema arasından size en uygun olanı seçin.</p>
				<div class="social-links">
					<a href="#" class="social-link">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M22 4L22 20L2 20L2 4L22 4Z M18 9L12 13.5L6 9"/>
						</svg>
					</a>
					<a href="#" class="social-link">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M23 3C23 3 20.5 4 18 5.5C16.5 3 13 3 11 5.5M23 3L18 9M23 3L16 16C15 18 13 19 10 19"/>
						</svg>
					</a>
					<a href="#" class="social-link">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M16 8C16 8 14 6 9 8M16 8L20 4M16 8L10 15M9 8L4 12M9 8L12 14"/>
						</svg>
					</a>
					<a href="#" class="social-link">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="12" cy="12" r="3"/>
							<path d="M19 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H19C20.1046 20 21 19.1046 21 18V6C21 4.89543 20.1046 4 19 4Z"/>
						</svg>
					</a>
				</div>
			</div>
			
			<!-- Quick Links -->
			<div class="footer-col">
				<h3>Hızlı Bağlantılar</h3>
				<ul class="footer-links">
					<li><a href="<?php echo home_url(); ?>">Ana Sayfa</a></li>
					<li><a href="#">Popüler Temalar</a></li>
					<li><a href="#">Yeni Çıkanlar</a></li>
					<li><a href="#">İndirimdekiler</a></li>
					<li><a href="/yazilar">Blog</a></li>
				</ul>
			</div>
			
			<!-- Categories -->
			<div class="footer-col">
				<h3>Kategoriler</h3>
				<ul class="footer-links">
					<?php
					try {
						$termModel = new \App\Models\Term();
						$categories = $termModel->getByTaxonomy('category');
						$categories = array_slice($categories, 0, 5);
						foreach ($categories as $cat):
					?>
					<li><a href="#"><?php echo htmlspecialchars($cat['name']); ?></a></li>
					<?php 
						endforeach;
					} catch (Exception $e) {}
					?>
				</ul>
			</div>
			
			<!-- Contact & Newsletter -->
			<div class="footer-col">
				<h3>İletişim</h3>
				<ul class="contact-info">
					<li>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
						</svg>
						<span>+90 555 123 45 67</span>
					</li>
					<li>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
							<polyline points="22,6 12,13 2,6"/>
						</svg>
						<span>info@<?php echo parse_url(get_option('site_url', ''), PHP_URL_HOST); ?></span>
					</li>
					<li>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
							<circle cx="12" cy="10" r="3"/>
						</svg>
						<span>İstanbul, Türkiye</span>
					</li>
				</ul>
			</div>
		</div>
		
		<!-- Newsletter Section -->
		<div class="footer-grid" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
			<div class="footer-col">
				<h3>Bülten</h3>
				<p>Yeni temalar ve fırsatlardan haberdar olmak için bültenimize abone olun.</p>
			</div>
			<div class="footer-col">
				<form class="newsletter-form" id="newsletterForm">
					<input type="email" class="newsletter-input" placeholder="E-posta adresiniz" required>
					<button type="submit" class="newsletter-btn">Abone Ol</button>
				</form>
			</div>
		</div>
		
		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<p>&copy; <?php echo date('Y'); ?> <?php echo get_option('site_name', 'DocedFrame'); ?>. Tüm hakları saklıdır.</p>
			<div class="footer-bottom-links">
				<a href="#">Gizlilik Politikası</a>
				<a href="#">Kullanım Şartları</a>
				<a href="#">Çerez Politikası</a>
			</div>
		</div>
	</div>
</footer>

<script>
// Newsletter Form
document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
	e.preventDefault();
	const email = this.querySelector('.newsletter-input').value;
	if (email) {
		alert('Bültenimize abone olduğunuz için teşekkürler!');
		this.reset();
	}
});
</script>

</body>
</html>