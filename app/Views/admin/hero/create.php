<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Yeni Hero Alanı - DocedFrame Admin</title>
	<style>
		.form-group { margin-bottom: 15px; }
		.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
		.form-group input, .form-group select, .form-group textarea { width: 100%; max-width: 500px; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
		.slider-item { background: #f9f9f9; padding: 15px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; }
		.slider-item input { width: 100%; margin-bottom: 10px; }
		button { background: #0073aa; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
		button:hover { background: #005a87; }
	</style>
</head>
<body>
	<h1>Yeni Hero Alanı Oluştur</h1>
	
	<form method="POST" action="/df-admin/hero/store" id="hero-form">
		<div class="form-group">
			<label>Hero Adı:</label>
			<input type="text" name="name" required placeholder="Örn: Ana Sayfa Hero">
		</div>
		
		<div class="form-group">
			<label>Hero Tipi:</label>
			<select name="type" id="hero-type">
				<option value="static">Statik Hero</option>
				<option value="slider">Slider Hero</option>
				<option value="search">Arama Hero</option>
			</select>
		</div>
		
		<!-- Statik Hero Alanları -->
		<div id="static-fields">
			<div class="form-group">
				<label>Başlık:</label>
				<input type="text" name="title" placeholder="Hero Başlığı">
			</div>
			
			<div class="form-group">
				<label>Alt Başlık:</label>
				<textarea name="subtitle" rows="3" placeholder="Hero alt başlığı"></textarea>
			</div>
			
			<div class="form-group">
				<label>Buton Metni:</label>
				<input type="text" name="button_text" placeholder="Örn: Keşfet">
			</div>
			
			<div class="form-group">
				<label>Buton URL:</label>
				<input type="text" name="button_url" placeholder="/hakkimizda">
			</div>
			
			<div class="form-group">
				<label>Arkaplan Resmi:</label>
				<input type="text" name="image" placeholder="/uploads/hero-bg.jpg">
			</div>
		</div>
		
		<!-- Slider Alanları -->
		<div id="slider-fields" style="display:none;">
			<h3>Slider Öğeleri</h3>
			<div id="slider-items-container">
				<div class="slider-item">
					<input type="text" name="slider_items[0][title]" placeholder="Slider Başlığı">
					<input type="text" name="slider_items[0][subtitle]" placeholder="Slider Alt Başlık">
					<input type="text" name="slider_items[0][button_text]" placeholder="Buton Metni">
					<input type="text" name="slider_items[0][button_url]" placeholder="Buton URL">
					<input type="text" name="slider_items[0][image]" placeholder="Resim URL">
				</div>
			</div>
			<button type="button" onclick="addSliderItem()">+ Slider Ekle</button>
		</div>
		
		<!-- Arama Hero Alanları -->
		<div id="search-fields" style="display:none;">
			<div class="form-group">
				<label>Başlık:</label>
				<input type="text" name="title" placeholder="Arama Hero Başlığı">
			</div>
			
			<div class="form-group">
				<label>Alt Başlık:</label>
				<textarea name="subtitle" rows="3" placeholder="Açıklama"></textarea>
			</div>
			
			<div class="form-group">
				<label>Arama Placeholder:</label>
				<input type="text" name="search_placeholder" value="Ara...">
			</div>
			
			<div class="form-group">
				<label>Arkaplan Resmi:</label>
				<input type="text" name="image" placeholder="/uploads/hero-bg.jpg">
			</div>
		</div>
		
		<button type="submit">Kaydet</button>
		<a href="/df-admin/hero">İptal</a>
	</form>
	
	<script>
		const heroType = document.getElementById('hero-type');
		const staticFields = document.getElementById('static-fields');
		const sliderFields = document.getElementById('slider-fields');
		const searchFields = document.getElementById('search-fields');
		
		heroType.addEventListener('change', function() {
			staticFields.style.display = 'none';
			sliderFields.style.display = 'none';
			searchFields.style.display = 'none';
			
			if (this.value === 'static') {
				staticFields.style.display = 'block';
			} else if (this.value === 'slider') {
				sliderFields.style.display = 'block';
			} else if (this.value === 'search') {
				searchFields.style.display = 'block';
			}
		});
		
		function addSliderItem() {
			const container = document.getElementById('slider-items-container');
			const index = container.children.length;
			const newItem = document.createElement('div');
			newItem.className = 'slider-item';
			newItem.innerHTML = `
				<input type="text" name="slider_items[${index}][title]" placeholder="Slider Başlığı">
				<input type="text" name="slider_items[${index}][subtitle]" placeholder="Slider Alt Başlık">
				<input type="text" name="slider_items[${index}][button_text]" placeholder="Buton Metni">
				<input type="text" name="slider_items[${index}][button_url]" placeholder="Buton URL">
				<input type="text" name="slider_items[${index}][image]" placeholder="Resim URL">
				<button type="button" onclick="this.parentElement.remove()">Sil</button>
			`;
			container.appendChild(newItem);
		}
	</script>
</body>
</html>