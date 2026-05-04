/**
 * DocedFrame Ana Tema JS
 * Versiyon: 1.3
 * Tarih: 03.05.2026
 */

(function() {
	// ========================================
	// Scroll efekti
	// ========================================
	var mainNav = document.getElementById('mainNav');
	if (mainNav) {
		window.addEventListener('scroll', function() {
			if (window.scrollY > 50) {
				mainNav.classList.add('scrolled');
			} else {
				mainNav.classList.remove('scrolled');
			}
		});
	}
	
	// ========================================
	// Hesap Menüsü
	// ========================================
	var accountBtn = document.getElementById('accountBtn');
	var accountMenu = document.getElementById('accountMenu');
	
	if (accountBtn && accountMenu) {
		accountBtn.addEventListener('click', function(e) {
			e.stopPropagation();
			accountMenu.classList.toggle('open');
		});
		
		document.addEventListener('click', function(e) {
			if (!accountBtn.contains(e.target) && !accountMenu.contains(e.target)) {
				accountMenu.classList.remove('open');
			}
		});
	}
	
	// ========================================
	// Sepet Dropdown
	// ========================================
	var cartBtn = document.getElementById('cartBtn');
	var cartMenu = document.getElementById('cartMenu');
	var cartCloseBtn = document.getElementById('cartCloseBtn');
	
	if (cartBtn && cartMenu) {
		cartBtn.addEventListener('click', function(e) {
			e.stopPropagation();
			cartMenu.classList.toggle('open');
		});
		
		if (cartCloseBtn) {
			cartCloseBtn.addEventListener('click', function(e) {
				e.stopPropagation();
				cartMenu.classList.remove('open');
			});
		}
		
		document.addEventListener('click', function(e) {
			if (!cartBtn.contains(e.target) && !cartMenu.contains(e.target)) {
				cartMenu.classList.remove('open');
			}
		});
	}
	
	// ========================================
	// Hamburger Menü
	// ========================================
	var hamburger = document.getElementById('hamburgerBtn');
	var navMenu = document.getElementById('navMenu');
	
	if (hamburger && navMenu) {
		hamburger.addEventListener('click', function(e) {
			e.stopPropagation();
			navMenu.classList.toggle('active');
			var spans = hamburger.querySelectorAll('span');
			if (navMenu.classList.contains('active')) {
				if (spans[0]) spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
				if (spans[1]) spans[1].style.opacity = '0';
				if (spans[2]) spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
			} else {
				if (spans[0]) spans[0].style.transform = 'none';
				if (spans[1]) spans[1].style.opacity = '1';
				if (spans[2]) spans[2].style.transform = 'none';
			}
		});
	}
	
	// ========================================
	// Butonlar
	// ========================================
	var signupBtn = document.getElementById('signupBtn');
	var loginBtn = document.getElementById('loginBtn');
	
	if (signupBtn) {
		signupBtn.addEventListener('click', function() {
			window.location.href = '/kayit';
		});
	}
	
	if (loginBtn) {
		loginBtn.addEventListener('click', function() {
			window.location.href = '/df-admin/login';
		});
	}
	
	// ========================================
	// Sepet Sistemi
	// ========================================
	var cart = JSON.parse(localStorage.getItem('cart')) || [];
	
	function saveCart() {
		localStorage.setItem('cart', JSON.stringify(cart));
		updateCartUI();
	}
	
	function updateCartUI() {
		var cartCount = document.getElementById('cartCount');
		var cartItems = document.getElementById('cartItems');
		var cartTotal = document.getElementById('cartTotal');
		
		var totalItems = 0;
		var totalPrice = 0;
		
		for (var i = 0; i < cart.length; i++) {
			totalItems += cart[i].quantity;
			totalPrice += cart[i].price * cart[i].quantity;
		}
		
		if (cartCount) cartCount.textContent = totalItems;
		
		if (cartItems) {
			if (cart.length === 0) {
				cartItems.innerHTML = '<div class="cart-empty"><p>Sepetiniz boş</p></div>';
			} else {
				var html = '';
				for (var i = 0; i < cart.length; i++) {
					var item = cart[i];
					html += '<div class="cart-item">';
					html += '<img src="' + (item.image || '/themes/default/assets/images/placeholder.jpg') + '" class="cart-item-img">';
					html += '<div class="cart-item-info">';
					html += '<div class="cart-item-title">' + escapeHtml(item.name) + '</div>';
					html += '<div class="cart-item-price">$' + item.price + '</div>';
					html += '<div class="cart-item-actions">';
					html += '<span class="cart-item-qty">Adet: ' + item.quantity + '</span>';
					html += '<button class="cart-remove-btn" data-id="' + item.id + '">Sil</button>';
					html += '</div></div></div>';
				}
				cartItems.innerHTML = html;
				
				document.querySelectorAll('.cart-remove-btn').forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.stopPropagation();
						var id = parseInt(this.dataset.id);
						var newCart = [];
						for (var j = 0; j < cart.length; j++) {
							if (cart[j].id !== id) {
								newCart.push(cart[j]);
							}
						}
						cart = newCart;
						saveCart();
					});
				});
			}
		}
		
		if (cartTotal) cartTotal.textContent = '$' + totalPrice.toFixed(2);
	}
	
	function escapeHtml(text) {
		if (!text) return '';
		return text.replace(/[&<>]/g, function(m) {
			if (m === '&') return '&amp;';
			if (m === '<') return '&lt;';
			if (m === '>') return '&gt;';
			return m;
		});
	}
	
	window.addToCart = function(product) {
		var found = false;
		for (var i = 0; i < cart.length; i++) {
			if (cart[i].id === product.id) {
				cart[i].quantity++;
				found = true;
				break;
			}
		}
		if (!found) {
			cart.push({
				id: product.id,
				name: product.name,
				price: product.price,
				image: product.image || '/themes/default/assets/images/placeholder.jpg',
				quantity: 1
			});
		}
		saveCart();
		
		var modal = document.getElementById('cartModal');
		if (modal) {
			var productName = document.getElementById('cartProductName');
			var productPrice = document.getElementById('cartProductPrice');
			var productImage = document.getElementById('cartProductImage');
			if (productName) productName.textContent = product.name;
			if (productPrice) productPrice.textContent = '$' + product.price;
			if (productImage) productImage.src = product.image || '/themes/default/assets/images/placeholder.jpg';
			modal.classList.add('open');
			setTimeout(function() { modal.classList.remove('open'); }, 3000);
		}
	};
	
	// Sepet Modal
	var cartModalClose = document.getElementById('cartModalClose');
	var cartContinueBtn = document.getElementById('cartContinueBtn');
	var cartViewBtn = document.getElementById('cartViewBtn');
	
	if (cartModalClose) {
		cartModalClose.addEventListener('click', function() {
			var modal = document.getElementById('cartModal');
			if (modal) modal.classList.remove('open');
		});
	}
	
	if (cartContinueBtn) {
		cartContinueBtn.addEventListener('click', function() {
			var modal = document.getElementById('cartModal');
			if (modal) modal.classList.remove('open');
		});
	}
	
	if (cartViewBtn) {
		cartViewBtn.addEventListener('click', function() {
			window.location.href = '/sepet';
		});
	}
	
	updateCartUI();
})();

// ========================================
// Hero Arama
// ========================================

(function() {
	var categorySelect = document.getElementById('heroCategorySelect');
	var categoryTrigger = categorySelect ? categorySelect.querySelector('.category-select-trigger') : null;
	var categoryOptions = categorySelect ? categorySelect.querySelectorAll('.category-option') : [];
	var categoryInput = document.getElementById('heroCategoryInput');
	var selectedCategorySpan = document.getElementById('heroSelectedCategory');
	var searchInput = document.getElementById('heroSearchInput');
	var searchBtn = document.getElementById('heroSearchBtn');
	var resultsContainer = document.getElementById('heroSearchResults');
	var resultsList = document.getElementById('resultsList');
	var resultsCountSpan = document.getElementById('resultsCount');
	var resultsFooter = document.getElementById('resultsFooter');
	var showAllBtn = document.getElementById('showAllResultsBtn');
	
	var currentCategory = 'all';
	var currentQuery = '';
	
	if (categoryTrigger) {
		categoryTrigger.addEventListener('click', function(e) {
			e.stopPropagation();
			if (categorySelect) categorySelect.classList.toggle('open');
		});
	}
	
	categoryOptions.forEach(function(option) {
		option.addEventListener('click', function() {
			var value = this.dataset.value;
			var text = this.textContent;
			
			categoryOptions.forEach(function(opt) {
				opt.classList.remove('selected');
			});
			this.classList.add('selected');
			
			if (categoryInput) categoryInput.value = value;
			if (selectedCategorySpan) selectedCategorySpan.textContent = text;
			currentCategory = value;
			
			if (categorySelect) categorySelect.classList.remove('open');
			
			if (currentQuery.length > 0) {
				performSearch();
			}
		});
	});
	
	document.addEventListener('click', function(e) {
		if (categorySelect && !categorySelect.contains(e.target)) {
			categorySelect.classList.remove('open');
		}
		if (resultsContainer && resultsContainer.style.display !== 'none') {
			if (!resultsContainer.contains(e.target) && 
				!searchInput.contains(e.target) && 
				!searchBtn.contains(e.target)) {
				resultsContainer.style.display = 'none';
			}
		}
	});
	
	function performSearch() {
		var query = searchInput ? searchInput.value.trim() : '';
		currentQuery = query;
		
		if (query.length === 0) {
			if (resultsContainer) resultsContainer.style.display = 'none';
			return;
		}
		
		var xhr = new XMLHttpRequest();
		var url = '/ajax/arama?q=' + encodeURIComponent(query) + '&category=' + encodeURIComponent(currentCategory);
		xhr.open('GET', url, true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				try {
					var data = JSON.parse(xhr.responseText);
					displayResults(data);
				} catch(e) {
					console.error('JSON parse error:', e);
				}
			}
		};
		xhr.send();
	}
	
	function displayResults(data) {
		if (!resultsContainer || !resultsList) return;
		
		var count = data.length || 0;
		if (resultsCountSpan) resultsCountSpan.textContent = count;
		
		if (count === 0) {
			resultsList.innerHTML = '<div style="padding: 2rem; text-align: center; color: #94a3b8;">Sonuç bulunamadı</div>';
			if (resultsFooter) resultsFooter.style.display = 'none';
		} else {
			var html = '';
			for (var i = 0; i < Math.min(data.length, 5); i++) {
				var item = data[i];
				html += '<div class="result-item" data-url="' + (item.url || '/yazi/' + item.slug) + '">';
				html += '<img src="' + (item.image || '/themes/default/assets/images/placeholder.jpg') + '" class="result-image">';
				html += '<div class="result-details">';
				html += '<div class="result-name">' + escapeHtml2(item.title) + '</div>';
				html += '<div class="result-category">' + escapeHtml2(item.type || 'Yazı') + '</div>';
				if (item.price) html += '<div class="result-price">$' + item.price + '</div>';
				html += '</div></div>';
			}
			resultsList.innerHTML = html;
			
			document.querySelectorAll('.result-item').forEach(function(item) {
				item.addEventListener('click', function() {
					var url = this.dataset.url;
					if (url) window.location.href = url;
				});
			});
			
			if (resultsFooter) {
				if (data.length > 5) {
					resultsFooter.style.display = 'block';
					if (showAllBtn) {
						showAllBtn.onclick = function() {
							window.location.href = '/arama?s=' + encodeURIComponent(currentQuery) + '&category=' + encodeURIComponent(currentCategory);
						};
					}
				} else {
					resultsFooter.style.display = 'none';
				}
			}
		}
		
		resultsContainer.style.display = 'block';
	}
	
	function escapeHtml2(text) {
		if (!text) return '';
		var div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}
	
	if (searchBtn) {
		searchBtn.addEventListener('click', function() {
			performSearch();
		});
	}
	
	if (searchInput) {
		searchInput.addEventListener('keypress', function(e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				performSearch();
			}
		});
	}
	
	var tagLinks = document.querySelectorAll('.tag-link');
	tagLinks.forEach(function(tag) {
		tag.addEventListener('click', function(e) {
			e.preventDefault();
			var tagValue = this.dataset.tag;
			if (searchInput) {
				searchInput.value = tagValue;
				currentQuery = tagValue;
				performSearch();
			}
		});
	});
})();

// ========================================
// Tema Kartları - Filtre ve Sıralama
// ========================================

(function() {
	var productGrid = document.getElementById('productGrid');
	var loadMoreBtn = document.getElementById('loadMoreBtn');
	var visibleCount = 6;
	
	function getAllCards() {
		if (productGrid) {
			return Array.from(productGrid.querySelectorAll('.theme-card'));
		}
		return [];
	}
	
	function updateVisibleCards() {
		if (!productGrid) return;
		
		var cards = getAllCards();
		cards.forEach(function(card, index) {
			if (index < visibleCount) {
				card.style.display = '';
			} else {
				card.style.display = 'none';
			}
		});
		
		if (loadMoreBtn) {
			if (visibleCount >= cards.length) {
				loadMoreBtn.style.display = 'none';
			} else {
				loadMoreBtn.style.display = 'block';
			}
		}
	}
	
	function filterCards(filter) {
		var cards = getAllCards();
		cards.forEach(function(card) {
			var category = card.dataset.category;
			if (filter === 'all' || category === filter) {
				card.style.display = '';
			} else {
				card.style.display = 'none';
			}
		});
		
		var visibleCards = getAllCards().filter(function(card) { return card.style.display !== 'none'; });
		visibleCount = Math.min(visibleCount, visibleCards.length);
		updateVisibleCards();
	}
	
	var filterTabs = document.querySelectorAll('.filter-tab');
	filterTabs.forEach(function(tab) {
		tab.addEventListener('click', function() {
			filterTabs.forEach(function(t) { t.classList.remove('active'); });
			this.classList.add('active');
			var filter = this.dataset.filter;
			filterCards(filter);
		});
	});
	
	var sortWrapper = document.getElementById('sortWrapper');
	var sortTrigger = document.getElementById('sortTrigger');
	var selectedSortSpan = document.getElementById('selectedSort');
	
	function sortCards(sortType) {
		var grid = productGrid;
		if (!grid) return;
		
		var cards = getAllCards();
		
		if (sortType === 'popular') {
			cards.sort(function(a, b) {
				var aSales = parseInt(a.dataset.sales) || 0;
				var bSales = parseInt(b.dataset.sales) || 0;
				return bSales - aSales;
			});
		} else if (sortType === 'price-low') {
			cards.sort(function(a, b) {
				var aPrice = parseFloat(a.dataset.price) || 0;
				var bPrice = parseFloat(b.dataset.price) || 0;
				return aPrice - bPrice;
			});
		} else if (sortType === 'price-high') {
			cards.sort(function(a, b) {
				var aPrice = parseFloat(a.dataset.price) || 0;
				var bPrice = parseFloat(b.dataset.price) || 0;
				return bPrice - aPrice;
			});
		} else if (sortType === 'rating') {
			cards.sort(function(a, b) {
				var aRating = parseFloat(a.dataset.rating) || 0;
				var bRating = parseFloat(b.dataset.rating) || 0;
				return bRating - aRating;
			});
		}
		
		cards.forEach(function(card) { grid.appendChild(card); });
		visibleCount = 6;
		updateVisibleCards();
	}
	
	if (sortTrigger && sortWrapper) {
		sortTrigger.addEventListener('click', function(e) {
			e.stopPropagation();
			sortWrapper.classList.toggle('open');
		});
		
		var sortOptions = document.querySelectorAll('.sort-option');
		sortOptions.forEach(function(option) {
			option.addEventListener('click', function() {
				sortOptions.forEach(function(opt) { opt.classList.remove('selected'); });
				this.classList.add('selected');
				var sortValue = this.dataset.value;
				if (selectedSortSpan) selectedSortSpan.textContent = this.textContent;
				sortWrapper.classList.remove('open');
				sortCards(sortValue);
			});
		});
		
		document.addEventListener('click', function(e) {
			if (sortWrapper && !sortWrapper.contains(e.target)) {
				sortWrapper.classList.remove('open');
			}
		});
	}
	
	function initFavButtons() {
		var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
		
		var favBtns = document.querySelectorAll('.fav-btn');
		favBtns.forEach(function(btn) {
			var productId = parseInt(btn.dataset.id);
			if (favorites.includes(productId)) {
				btn.classList.add('active');
			}
			
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var id = parseInt(this.dataset.id);
				var index = favorites.indexOf(id);
				if (index === -1) {
					favorites.push(id);
					this.classList.add('active');
				} else {
					favorites.splice(index, 1);
					this.classList.remove('active');
				}
				localStorage.setItem('favorites', JSON.stringify(favorites));
			});
		});
	}
	
	if (loadMoreBtn) {
		loadMoreBtn.addEventListener('click', function() {
			visibleCount += 3;
			updateVisibleCards();
		});
	}
	
	updateVisibleCards();
	initFavButtons();
})();

// ========================================
// Single Page - Tabs, Reviews, Editor
// ========================================

document.addEventListener('DOMContentLoaded', function() {
	
	// TABS
	var tabBtns = document.querySelectorAll('.tab-btn');
	var tabPanes = document.querySelectorAll('.tab-pane');
	
	tabBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var tabId = this.dataset.tab;
			
			tabBtns.forEach(function(b) { b.classList.remove('active'); });
			tabPanes.forEach(function(p) { p.classList.remove('active'); });
			
			this.classList.add('active');
			var activePane = document.getElementById(tabId);
			if (activePane) activePane.classList.add('active');
		});
	});
	
	// REVIEW FORM
	var writeReviewBtn = document.getElementById('writeReviewBtn');
	var reviewFormContainer = document.getElementById('reviewFormContainer');
	var cancelReviewBtn = document.getElementById('cancelReviewBtn');
	
	if (writeReviewBtn && reviewFormContainer) {
		writeReviewBtn.addEventListener('click', function() {
			reviewFormContainer.classList.add('open');
			this.style.display = 'none';
		});
	}
	
	if (cancelReviewBtn && reviewFormContainer && writeReviewBtn) {
		cancelReviewBtn.addEventListener('click', function() {
			reviewFormContainer.classList.remove('open');
			writeReviewBtn.style.display = 'block';
		});
	}
	
	// RATING STARS
	var starInputs = document.querySelectorAll('.star-input');
	var ratingValueInput = document.getElementById('ratingValue');
	var currentRating = 0;
	
	starInputs.forEach(function(star, index) {
		star.addEventListener('click', function() {
			currentRating = index + 1;
			if (ratingValueInput) ratingValueInput.value = currentRating;
			
			starInputs.forEach(function(s, i) {
				var svg = s.querySelector('svg');
				if (i <= index) {
					s.classList.add('selected');
					if (svg) {
						svg.style.fill = '#f59e0b';
						svg.style.stroke = '#f59e0b';
					}
				} else {
					s.classList.remove('selected');
					if (svg) {
						svg.style.fill = 'none';
						svg.style.stroke = '#cbd5e1';
					}
				}
			});
		});
		
		star.addEventListener('mouseenter', function() {
			starInputs.forEach(function(s, i) {
				var svg = s.querySelector('svg');
				if (i <= index) {
					if (svg) {
						svg.style.fill = '#f59e0b';
						svg.style.stroke = '#f59e0b';
					}
				}
			});
		});
		
		star.addEventListener('mouseleave', function() {
			starInputs.forEach(function(s, i) {
				if (!s.classList.contains('selected')) {
					var svg = s.querySelector('svg');
					if (svg) {
						svg.style.fill = 'none';
						svg.style.stroke = '#cbd5e1';
					}
				}
			});
		});
	});
	
	// EDITOR
	var editorContent = document.getElementById('editorContent');
	var editorBtns = document.querySelectorAll('.editor-btn');
	
	function execCommand(command, value) {
		document.execCommand(command, false, value || null);
		if (editorContent) editorContent.focus();
	}
	
	editorBtns.forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			var command = this.dataset.command;
			var value = this.dataset.value || null;
			
			switch(command) {
				case 'bold': execCommand('bold'); break;
				case 'italic': execCommand('italic'); break;
				case 'underline': execCommand('underline'); break;
				case 'strikeThrough': execCommand('strikeThrough'); break;
				case 'justifyLeft': execCommand('justifyLeft'); break;
				case 'justifyCenter': execCommand('justifyCenter'); break;
				case 'justifyRight': execCommand('justifyRight'); break;
				case 'insertUnorderedList': execCommand('insertUnorderedList'); break;
				case 'insertOrderedList': execCommand('insertOrderedList'); break;
				case 'createLink': 
					var url = prompt('Link URL girin:', 'https://');
					if (url) execCommand('createLink', url);
					break;
				case 'unlink': execCommand('unlink'); break;
				default: execCommand(command, value);
			}
		});
	});
	
	// SUBMIT REVIEW
	var submitReviewBtn = document.getElementById('submitReviewBtn');
	if (submitReviewBtn) {
		submitReviewBtn.addEventListener('click', function() {
			var reviewTitle = document.getElementById('reviewTitle');
			var reviewTitleValue = reviewTitle ? reviewTitle.value : '';
			var reviewContentValue = editorContent ? editorContent.innerHTML : '';
			
			if (!currentRating) {
				alert('Lütfen puan verin!');
				return;
			}
			if (!reviewTitleValue.trim()) {
				alert('Lütfen yorum başlığı girin!');
				return;
			}
			if (!reviewContentValue.trim() || reviewContentValue === '<br>') {
				alert('Lütfen yorum içeriği girin!');
				return;
			}
			
			alert('Yorumunuz başarıyla gönderildi! Onaylandıktan sonra yayınlanacaktır.');
			
			if (reviewTitle) reviewTitle.value = '';
			if (editorContent) editorContent.innerHTML = '';
			starInputs.forEach(function(s) {
				s.classList.remove('selected');
				var svg = s.querySelector('svg');
				if (svg) {
					svg.style.fill = 'none';
					svg.style.stroke = '#cbd5e1';
				}
			});
			currentRating = 0;
			if (reviewFormContainer) reviewFormContainer.classList.remove('open');
			if (writeReviewBtn) writeReviewBtn.style.display = 'block';
		});
	}
	
	// BUY BUTTON
	var buyBtn = document.getElementById('buyNowBtn');
	if (buyBtn) {
		buyBtn.addEventListener('click', function() {
			alert('Sepete eklendi! Ödeme sayfasına yönlendiriliyorsunuz.');
		});
	}
	
	// DEMO BUTTON
	var demoBtn = document.getElementById('demoFullBtn');
	if (demoBtn) {
		demoBtn.addEventListener('click', function(e) {
			e.preventDefault();
			window.open('#', '_blank');
		});
	}
	
	// SHARE BUTTONS
	var shareBtns = document.querySelectorAll('.share-btn');
	shareBtns.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var platform = this.dataset.platform;
			var url = encodeURIComponent(window.location.href);
			var title = encodeURIComponent(document.title);
			var shareUrl = '';
			
			if (platform === 'twitter') {
				shareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title;
			} else if (platform === 'facebook') {
				shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
			} else if (platform === 'linkedin') {
				shareUrl = 'https://www.linkedin.com/sharing/share-offsite/?url=' + url;
			}
			
			if (shareUrl) {
				window.open(shareUrl, '_blank', 'width=600,height=400');
			}
		});
	});
	
	// NEWSLETTER
	var newsletterForm = document.getElementById('newsletterForm');
	if (newsletterForm) {
		newsletterForm.addEventListener('submit', function(e) {
			e.preventDefault();
			var emailInput = this.querySelector('.newsletter-input');
			var email = emailInput ? emailInput.value : '';
			if (email) {
				alert('Bültenimize abone olduğunuz için teşekkürler!');
				this.reset();
			}
		});
	}
});

// ========================================
// Register Page Script
// ========================================

(function() {
	// Sayfa register sayfası mı kontrol et
	if (!document.querySelector('.page-register')) return;
	
	// PASSWORD TOGGLE - Tab tuşu ile geçiş
	var toggleBtns = document.querySelectorAll('.toggle-password');
	
	toggleBtns.forEach(function(btn) {
		btn.setAttribute('tabindex', '-1');
		
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			var targetId = this.dataset.target;
			var input = document.getElementById(targetId);
			
			if (input) {
				var type = input.type === 'password' ? 'text' : 'password';
				input.type = type;
				input.focus();
				
				var svg = this.querySelector('svg');
				if (type === 'text') {
					svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/><line x1="3" y1="3" x2="21" y2="21"/>';
				} else {
					svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
				}
			}
		});
	});
	
	// PASSWORD STRENGTH - Dinamik bar
	var passwordInput = document.getElementById('password');
	var strengthProgress = document.querySelector('.strength-progress');
	var strengthText = document.querySelector('.strength-text');
	
	function checkPasswordStrength(password) {
		var strength = 0;
		
		if (!password) {
			if (strengthProgress) strengthProgress.style.width = '0%';
			if (strengthText) strengthText.textContent = 'Şifre güvenliği';
			return 0;
		}
		
		if (password.length >= 6) strength++;
		if (password.length >= 10) strength++;
		if (/[A-Z]/.test(password)) strength++;
		if (/[0-9]/.test(password)) strength++;
		if (/[^A-Za-z0-9]/.test(password)) strength++;
		
		var percentages = {
			0: { width: '20%', color: '#ef4444', text: 'Çok Zayıf' },
			1: { width: '20%', color: '#ef4444', text: 'Zayıf' },
			2: { width: '40%', color: '#f59e0b', text: 'Orta' },
			3: { width: '60%', color: '#f59e0b', text: 'Orta' },
			4: { width: '80%', color: '#10b981', text: 'Güçlü' },
			5: { width: '100%', color: '#10b981', text: 'Çok Güçlü' }
		};
		
		var result = percentages[strength] || percentages[0];
		
		if (strengthProgress) {
			strengthProgress.style.width = result.width;
			strengthProgress.style.backgroundColor = result.color;
		}
		if (strengthText) {
			strengthText.textContent = result.text;
			strengthText.style.color = result.color;
		}
		
		return strength;
	}
	
	if (passwordInput) {
		passwordInput.addEventListener('input', function() {
			checkPasswordStrength(this.value);
		});
		
		// Sayfa yüklendiğinde varsa kontrol et
		if (passwordInput.value) {
			checkPasswordStrength(passwordInput.value);
		}
	}
	
	// TOAST MESAJ FONKSİYONU
	function showToast(message, type) {
		var toast = document.getElementById('toastMessage');
		if (!toast) return;
		
		toast.textContent = message;
		toast.className = 'toast-message toast-' + type;
		toast.style.display = 'block';
		
		setTimeout(function() {
			toast.style.display = 'none';
		}, 5000);
	}
	
	// REGISTER FORM
	var registerForm = document.getElementById('registerForm');
	
	if (registerForm) {
		registerForm.addEventListener('submit', function(e) {
			e.preventDefault();
			
			var firstName = document.getElementById('firstName').value;
			var lastName = document.getElementById('lastName').value;
			var email = document.getElementById('email').value;
			var password = document.getElementById('password').value;
			var confirmPassword = document.getElementById('confirmPassword').value;
			var terms = document.getElementById('terms').checked;
			var newsletter = document.getElementById('newsletter').checked ? 1 : 0;
			
			// Alanları temizle
			document.querySelectorAll('.field-error').forEach(function(el) { el.remove(); });
			document.querySelectorAll('.form-input').forEach(function(el) { el.classList.remove('error'); });
			
			var hasError = false;
			
			if (!firstName.trim()) {
				showError('firstName', 'Lütfen adınızı girin.');
				hasError = true;
			} else if (firstName.trim().length < 2) {
				showError('firstName', 'Ad en az 2 karakter olmalıdır.');
				hasError = true;
			}
			
			if (!lastName.trim()) {
				showError('lastName', 'Lütfen soyadınızı girin.');
				hasError = true;
			} else if (lastName.trim().length < 2) {
				showError('lastName', 'Soyad en az 2 karakter olmalıdır.');
				hasError = true;
			}
			
			if (!email.trim()) {
				showError('email', 'Lütfen e-posta adresinizi girin.');
				hasError = true;
			} else if (!email.includes('@')) {
				showError('email', 'Lütfen geçerli bir e-posta adresi girin.');
				hasError = true;
			}
			
			if (!password) {
				showError('password', 'Lütfen şifrenizi girin.');
				hasError = true;
			} else if (password.length < 6) {
				showError('password', 'Şifre en az 6 karakter olmalıdır.');
				hasError = true;
			} else if (checkPasswordStrength(password) < 3) {
				showError('password', 'Lütfen daha güçlü bir şifre belirleyin.');
				hasError = true;
			}
			
			if (password !== confirmPassword) {
				showError('confirmPassword', 'Şifreler eşleşmiyor.');
				hasError = true;
			}
			
			if (!terms) {
				showError('terms', 'Kullanım koşullarını kabul etmelisiniz.');
				hasError = true;
			}
			
			if (hasError) return;
			
			// AJAX ile kayıt
			var formData = new FormData();
			formData.append('first_name', firstName);
			formData.append('last_name', lastName);
			formData.append('email', email);
			formData.append('password', password);
			formData.append('confirm_password', confirmPassword);
			formData.append('newsletter', newsletter);
			formData.append('terms', terms ? 1 : 0);
			
			fetch('/kayit', {
				method: 'POST',
				body: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(function(response) { return response.json(); })
			.then(function(data) {
				if (data.success) {
					showToast(data.message || 'Kaydınız başarıyla oluşturuldu!', 'success');
					setTimeout(function() {
						window.location.href = '/df-admin/login';
					}, 2000);
				} else if (data.errors) {
					for (var field in data.errors) {
						showError(field, data.errors[field]);
					}
				} else {
					showToast(data.message || 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
				}
			})
			.catch(function(error) {
				console.error('Error:', error);
				showToast('Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
			});
		});
	}
	
	function showError(fieldName, message) {
		var field = document.getElementById(fieldName);
		if (field) {
			field.classList.add('error');
			var parent = field.closest('.form-group');
			if (parent) {
				var existingError = parent.querySelector('.field-error');
				if (existingError) existingError.remove();
				var errorDiv = document.createElement('div');
				errorDiv.className = 'field-error';
				errorDiv.textContent = message;
				parent.appendChild(errorDiv);
			}
		}
	}
	
	// SOSYAL REGISTER BUTONLARI
	var googleRegisterBtn = document.getElementById('googleRegisterBtn');
	var facebookRegisterBtn = document.getElementById('facebookRegisterBtn');
	
	if (googleRegisterBtn) {
		googleRegisterBtn.addEventListener('click', function() {
			showToast('Google ile kayıt özelliği yakında gelecektir.', 'info');
		});
	}
	
	if (facebookRegisterBtn) {
		facebookRegisterBtn.addEventListener('click', function() {
			showToast('Facebook ile kayıt özelliği yakında gelecektir.', 'info');
		});
	}
	
	// AUTO FOCUS
	var firstNameInput = document.getElementById('firstName');
	if (firstNameInput) {
		firstNameInput.focus();
	}
})();