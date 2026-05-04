<?php include __DIR__ . '/header.php'; ?>

<section class="single-page">
	<!-- Breadcrumb -->
	<div class="breadcrumb">
		<a href="<?php echo home_url(); ?>">Ana Sayfa</a>
		<span>/</span>
		<a href="/yazilar">Yazılar</a>
		<span>/</span>
		<span class="current"><?php echo htmlspecialchars($post['title']); ?></span>
	</div>
	
	<div class="single-grid">
		<!-- Main Content -->
		<div class="single-main">
			<div class="theme-image">
				<img src="<?php echo get_post_image($post['id']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
				<div class="image-badges">
					<span class="image-badge hot">POPÜLER</span>
				</div>
			</div>
			
			<div class="theme-info">
				<h1 class="theme-title"><?php echo htmlspecialchars($post['title']); ?></h1>
				<span class="theme-category"><?php echo ucfirst($post['type']); ?> | Tema | <?php echo date('d M Y', strtotime($post['created_at'])); ?></span>
				
				<!-- Post Stats -->
				<div class="theme-stats">
					<div class="stat-box">
						<div class="stat-icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 4L12 20M20 12L4 12"/>
							</svg>
						</div>
						<div class="stat-content">
							<div class="stat-label">Okunma</div>
							<div class="stat-value">1,250+</div>
						</div>
					</div>
					<div class="stat-box">
						<div class="stat-icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/>
							</svg>
						</div>
						<div class="stat-content">
							<div class="stat-label">Puan</div>
							<div class="stat-rating">
								<div class="rating-stars-large">
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
								</div>
								<span class="rating-value-large">4.8</span>
								<span class="rating-count">(245 yorum)</span>
							</div>
						</div>
					</div>
					<div class="stat-box">
						<div class="stat-icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M3 12L5 10L8 13L13 7"/>
								<path d="M19 8L21 10L16 15L13 12"/>
							</svg>
						</div>
						<div class="stat-content">
							<div class="stat-label">Güncelleme</div>
							<div class="stat-value"><?php echo date('d M Y', strtotime($post['created_at'])); ?></div>
						</div>
					</div>
				</div>
				
				<!-- Tabs -->
				<div class="theme-tabs">
					<div class="tabs-header">
						<button class="tab-btn active" data-tab="tab-description">Açıklama</button>
						<button class="tab-btn" data-tab="tab-reviews">Değerlendirmeler</button>
						<button class="tab-btn" data-tab="tab-license">Lisans</button>
					</div>
					
					<!-- Description Tab -->
					<div class="tab-pane active" id="tab-description">
						<div class="description-content">
							<?php echo nl2br($post['content']); ?>
						</div>
					</div>
					
					<!-- Reviews Tab -->
					<div class="tab-pane" id="tab-reviews">
						<div class="reviews-header">
							<div class="reviews-summary">
								<div class="summary-rating">
									<div class="big-rating">4.8</div>
									<div class="rating-stars-large">
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									</div>
									<span class="rating-count">245 değerlendirme</span>
								</div>
							</div>
							<button class="write-review-btn" id="writeReviewBtn">Yorum Yaz</button>
						</div>
						
						<!-- Review Form -->
						<div class="review-form-container" id="reviewFormContainer">
							<div class="review-form-title">Yorum Yap</div>
							<div class="rating-input">
								<label>Puanınız</label>
								<div class="stars-input" id="starsInput">
									<div class="star-input" data-star="1"><svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg></div>
									<div class="star-input" data-star="2"><svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg></div>
									<div class="star-input" data-star="3"><svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg></div>
									<div class="star-input" data-star="4"><svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg></div>
									<div class="star-input" data-star="5"><svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg></div>
								</div>
								<input type="hidden" id="ratingValue" value="0">
							</div>
							<div class="review-title-input" style="margin-bottom: 1rem;">
								<input type="text" id="reviewTitle" class="newsletter-input" placeholder="Yorum başlığı" style="width: 100%;">
							</div>
							<div class="editor-container">
								<div class="editor-toolbar">
									<button type="button" class="editor-btn" data-command="bold" title="Kalın">B</button>
									<button type="button" class="editor-btn" data-command="italic" title="İtalik">I</button>
									<button type="button" class="editor-btn" data-command="underline" title="Altı Çizili">U</button>
									<button type="button" class="editor-btn" data-command="strikeThrough" title="Üstü Çizili">S</button>
									<span class="editor-divider"></span>
									<button type="button" class="editor-btn" data-command="justifyLeft" title="Sola Hizala">⧠</button>
									<button type="button" class="editor-btn" data-command="justifyCenter" title="Ortala">⬚</button>
									<button type="button" class="editor-btn" data-command="justifyRight" title="Sağa Hizala">⬛</button>
									<span class="editor-divider"></span>
									<button type="button" class="editor-btn" data-command="insertUnorderedList" title="Madde İşareti">•</button>
									<button type="button" class="editor-btn" data-command="insertOrderedList" title="Numaralı Liste">1.</button>
									<span class="editor-divider"></span>
									<button type="button" class="editor-btn" data-command="createLink" title="Link Ekle">🔗</button>
									<button type="button" class="editor-btn" data-command="unlink" title="Link Kaldır">🔗❌</button>
								</div>
								<div class="editor-content" id="editorContent" contenteditable="true"></div>
							</div>
							<div class="review-form-actions">
								<button class="btn-cancel-review" id="cancelReviewBtn">İptal</button>
								<button class="btn-submit-review" id="submitReviewBtn">Gönder</button>
							</div>
						</div>
						
						<!-- Reviews List -->
						<div class="reviews-list" id="reviewsList">
							<div class="review-item">
								<div class="review-header">
									<div class="reviewer-info">
										<div class="reviewer-avatar">A</div>
										<div>
											<div class="reviewer-name">Ahmet Yılmaz</div>
											<div class="review-date">15 Ocak 2024</div>
										</div>
									</div>
									<div class="review-rating">
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									</div>
								</div>
								<div class="review-title">Harika bir tema!</div>
								<div class="review-content">TechNova gerçekten mükemmel bir tema. Kurulumu çok kolay, çok hızlı ve kullanıcı dostu. Kesinlikle tavsiye ederim.</div>
							</div>
							<div class="review-item">
								<div class="review-header">
									<div class="reviewer-info">
										<div class="reviewer-avatar">M</div>
										<div>
											<div class="reviewer-name">Mehmet Demir</div>
											<div class="review-date">10 Ocak 2024</div>
										</div>
									</div>
									<div class="review-rating">
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
										<svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1"><path d="M12 2L15 9H22L16 14L19 21L12 17L5 21L8 14L2 9H9L12 2Z"/></svg>
									</div>
								</div>
								<div class="review-title">Güzel ama eksikleri var</div>
								<div class="review-content">Genel olarak güzel bir tema. Destek ekibi çok ilgili. Bazı özelliklerin geliştirilmesi gerekiyor.</div>
							</div>
						</div>
					</div>
					
					<!-- License Tab -->
					<div class="tab-pane" id="tab-license">
						<div class="license-content">
							<p>Bu içerik için lisans bilgileri aşağıdaki gibidir:</p>
							<ul class="license-list">
								<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Regular License: Tek bir web sitesi için kullanım</li>
								<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Extended License: Birden fazla web sitesi veya yeniden satış</li>
								<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> 6 ay ücretsiz destek (uzatılabilir)</li>
								<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Ömür boyu güncellemeler</li>
								<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> 14 gün para iade garantisi</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Sidebar -->
		<div class="single-sidebar">
			<!-- Price Card -->
			<div class="price-card">
				<div class="price-amount">
					<span class="current-price">$49</span>
					<span class="old-price">$99</span>
				</div>
				<div class="price-buttons">
					<button class="btn-buy-now" id="buyNowBtn">Satın Al</button>
					<a href="#" class="btn-demo-full" id="demoFullBtn">Canlı Demo</a>
				</div>
			</div>
			
			<!-- Info Card -->
			<div class="info-card">
				<h3>Ürün Bilgileri</h3>
				<ul class="info-list">
					<li><span class="info-label">Kategori</span><span class="info-value"><?php echo ucfirst($post['type']); ?></span></li>
					<li><span class="info-label">Son Güncelleme</span><span class="info-value"><?php echo date('d M Y', strtotime($post['created_at'])); ?></span></li>
					<li><span class="info-label">Versiyon</span><span class="info-value">2.5.0</span></li>
					<li><span class="info-label">Uyumluluk</span><span class="info-value">PHP 8.0+</span></li>
					<li><span class="info-label">Dosya Boyutu</span><span class="info-value">8.5 MB</span></li>
					<li><span class="info-label">Diller</span><span class="info-value">Türkçe, English</span></li>
				</ul>
			</div>
			
			<!-- Support Card -->
			<div class="info-card">
				<h3>Destek</h3>
				<ul class="info-list">
					<li><span class="info-label">Destek Süresi</span><span class="info-value">6 Ay</span></li>
					<li><span class="info-label">Geri Ödeme</span><span class="info-value">14 Gün</span></li>
					<li><span class="info-label">Dokümantasyon</span><span class="info-value">Var</span></li>
				</ul>
			</div>
			
			<!-- Share Card -->
			<div class="share-card">
				<h3>Paylaş</h3>
				<div class="share-buttons">
					<button class="share-btn" data-platform="twitter">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M23 3C23 3 20.5 4 18 5.5C16.5 3 13 3 11 5.5M23 3L18 9M23 3L16 16C15 18 13 19 10 19"/>
						</svg>
						Twitter
					</button>
					<button class="share-btn" data-platform="facebook">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
						</svg>
						Facebook
					</button>
					<button class="share-btn" data-platform="linkedin">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
							<rect x="2" y="9" width="4" height="12"/>
							<circle cx="4" cy="4" r="2"/>
						</svg>
						LinkedIn
					</button>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include __DIR__ . '/footer.php'; ?>