<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Hero Düzenle: <?php echo htmlspecialchars($hero['name']); ?> - DocedFrame Admin</title>
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
	<h1>Hero Düzenle: <?php echo htmlspecialchars($hero['name']); ?></h1>
	
	<form method="POST" action="/df-admin/hero/update/<?php echo $hero['id']; ?>" id="hero-form">
		<div class="form-group">
			<label>Hero Adı:</label>
			<input type="text" name="name" value="<?php echo htmlspecialchars($hero['name']); ?>" required>
		</div>
		
		<div class="form-group">
			<label>Hero Tipi:</label>
			<select name="type" id="hero-type">
				<option value="static" <?php echo $hero['type'] == 'static' ? 'selected' : ''; ?>>Statik Hero</option>
				<option value="slider" <?php echo $hero['type'] == 'slider' ? 'selected' : ''; ?>>Slider Hero</option>
				<option value="search" <?php echo $hero['type'] == 'search' ? 'selected' : ''; ?>>Arama Hero</option>
			</select>
		</div>
		
		<!-- Statik Hero Alanları -->
		<div id="static-fields" <?php echo $hero['type'] != 'static' ? 'style="display:none;"' : ''; ?>>
			<div class="form-group">
				<label>Başlık:</label>
				<input type="text" name="title" value="<?php echo htmlspecialchars($hero['title'] ?? ''); ?>">
			</div>
			
			<div class="form-group">
				<label>Alt Başlık:</label>
				<textarea name="subtitle" rows="3"><?php echo htmlspecialchars($hero['subtitle'] ?? ''); ?></textarea>
			</div>
			
			<div class="form-group">
				<label>Buton Metni:</label>
				<input type="text" name="button_text" value="<?php echo htmlspecialchars($hero['button_text'] ?? ''); ?>">
			</div>
			
			<div class="form-group">
				<label>Buton URL:</label>
				<input type="text" name="button_url" value="<?php echo htmlspecialchars($hero['button_url'] ?? ''); ?>">
			</div>
			
			<div class="form-group">
				<label>Arkaplan Resmi:</label>
				<input type="text" name="image" value="<?php echo htmlspecialchars($hero['image'] ?? ''); ?>">
			</div>
		</div>
		
		<!-- Slider Alanları -->
		<div id="slider-fields" <?php echo $hero['type'] != 'slider' ? 'style="display:none;"' : ''; ?>>
			<h3>Slider Öğeleri</h3>
			<div id="slider-items-container">
				<?php foreach ($sliders as $index => $item): ?>
				<div class="slider-item">
					<input type="text" name="slider_items[<?php echo $index; ?>][title]" placeholder="Slider Başlığı" value="<?php echo htmlspecialchars($item['title'] ?? ''); ?>">
					<input type="text" name="slider_items[<?php echo $index; ?>][subtitle]" placeholder="Slider Alt Başlık" value="<?php echo htmlspecialchars($item['subtitle'] ?? ''); ?>">
					<input type="text" name="slider_items[<?php echo $index; ?>][button_text]" placeholder="Buton Metni" value="<?php echo htmlspecialchars($item['button_text'] ?? ''); ?>">
					<input type="text" name="slider_items[<?php echo $index; ?>][button_url]" placeholder="Buton URL" value="<?php echo htmlspecialchars($item['button_url'] ?? ''); ?>">
					<input type="text" name="slider_items[<?php echo $index; ?>][image]" placeholder="Resim URL" value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>">
					<button type="button" onclick="this.parentElement.remove()">Sil</button>
				</div>
				<?php endforeach; ?>
			</div>
			<button type="button" onclick="addSliderItem()">+ Slider Ekle</button>
		</div>
		
		<!-- Arama Hero Alanları -->
		<div id="search-fields" <?php echo $hero['type'] != 'search' ? 'style="display:none;"' : ''; ?>>
			<div class="form-group">
				<label>Başlık:</label>
				<input type="text" name="title" value="<?php echo htmlspecialchars($hero['title'] ?? ''); ?>">
			</div>
			
			<div class="form-group">
				<label>Alt Başlık:</label>
				<textarea name="subtitle" rows="3"><?php echo htmlspecialchars($hero['subtitle'] ?? ''); ?></textarea>
			</div>
			
			<div class="form-group">
				<label>Arama Placeholder:</label>
				<input type="text" name="search_placeholder" value="<?php echo htmlspecialchars($hero['search_placeholder'] ?? 'Ara...'); ?>">
			</div>
			
			<div class="form-group">
				<label>Arkaplan Resmi:</label>
				<input type="text" name="image" value="<?php echo htmlspecialchars($hero['image'] ?? ''); ?>">
			</div>
		</div>
		
		<button type="submit">Güncelle</button>
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