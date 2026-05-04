<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<title>Menü Düzenle: <?php echo htmlspecialchars($menu['name']); ?> - DocedFrame Admin</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background: #f0f0f0; padding: 20px; }
		.menu-builder { display: flex; gap: 30px; margin-top: 20px; flex-wrap: wrap; }
		.menu-items-area { flex: 2; min-width: 500px; background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
		.menu-items-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 15px 20px; font-weight: bold; }
		.menu-items-container { padding: 20px; min-height: 500px; max-height: 600px; overflow-y: auto; }
		.menu-list { list-style: none; margin: 0; padding: 0; min-height: 100px; }
		.menu-item-wrapper { margin-bottom: 8px; }
		.menu-item { background: #fff; border: 1px solid #ddd; border-radius: 6px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
		.menu-item.dragging { opacity: 0.4; }
		.drop-target-before { border-top: 3px solid #28a745; margin-top: -1px; }
		.drop-target-after { border-bottom: 3px solid #28a745; margin-bottom: -1px; }
		.drop-target-inside { border: 2px dashed #667eea; background: #f8f9ff; }
		.menu-item-content { display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; }
		.menu-item-info { display: flex; align-items: center; gap: 10px; flex: 1; flex-wrap: wrap; }
		.drag-handle { cursor: move; color: #999; font-size: 20px; user-select: none; padding: 0 5px; }
		.drag-handle:hover { color: #667eea; }
		.menu-item-title { font-weight: 500; font-size: 14px; }
		.menu-item-url { font-size: 11px; color: #999; background: #f5f5f5; padding: 2px 6px; border-radius: 3px; }
		.menu-item-badge { font-size: 9px; padding: 2px 8px; border-radius: 12px; font-weight: normal; }
		.badge-dropdown { background: #f39c12; color: #fff; }
		.menu-item-actions { display: flex; gap: 12px; }
		.menu-item-actions a { color: #666; text-decoration: none; font-size: 14px; cursor: pointer; }
		.menu-item-actions a:hover { color: #0073aa; }
		.menu-item-actions .delete-btn { color: #dc3545; }
		.submenu-list { list-style: none; margin: 8px 0 8px 25px; padding-left: 15px; border-left: 2px dashed #ddd; }
		.add-item-area { flex: 1.5; min-width: 350px; background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; }
		.add-item-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 15px 20px; font-weight: bold; }
		.add-item-container { padding: 20px; }
		.form-group { margin-bottom: 15px; }
		.form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #333; }
		.form-group input, .form-group select { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
		button { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
		button:hover { opacity: 0.9; }
		.message { background: #d4edda; padding: 12px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724; }
		.help-text { font-size: 12px; color: #666; margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 4px; }
		.empty-placeholder { text-align: center; padding: 40px; color: #999; border: 2px dashed #ddd; border-radius: 8px; margin: 20px; }
		.edit-modal { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
		.edit-modal-content { background: #fff; border-radius: 8px; padding: 20px; width: 400px; max-width: 90%; }
		.edit-modal-header { margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #ddd; }
		.edit-modal-buttons { margin-top: 15px; display: flex; gap: 10px; justify-content: flex-end; }
	</style>
</head>
<body>
	<h1>Menü Düzenle: <?php echo htmlspecialchars($menu['name']); ?></h1>
	
	<?php if (isset($_SESSION['menu_message'])): ?>
	<div class="message">
		<?php echo $_SESSION['menu_message']; unset($_SESSION['menu_message']); ?>
	</div>
	<?php endif; ?>
	
	<div class="help-text">
		💡 <strong>İpucu:</strong> Menü öğelerini sürükleyip bırakarak düzenleyin.<br>
		• <strong>Üst kısma</strong> bırakın → Öğenin ÜSTÜNE ekler<br>
		• <strong>Alt kısma</strong> bırakın → Öğenin ALTINA ekler<br>
		• <strong>Orta kısma</strong> bırakın → Öğenin İÇİNE (alt öğe) ekler
	</div>
	
	<div class="menu-builder">
		<div class="menu-items-area">
			<div class="menu-items-header">
				📋 Menü Öğeleri (Sürükleyip bırakarak düzenleyin)
			</div>
			<div class="menu-items-container">
				<div id="empty-placeholder" class="empty-placeholder" style="display: none;">📂 Henüz menü öğesi yok</div>
				<form method="POST" action="/df-admin/menus/update-items/<?php echo $menu['id']; ?>" id="menu-form">
					<ul id="menu-list" class="menu-list">
						<?php echo renderMenuItems($items, $menu['id']); ?>
					</ul>
					<input type="hidden" name="items_order" id="items-order-input" value="">
					<div style="margin-top: 15px; display: flex; gap: 10px;">
						<button type="button" id="save-order-btn">💾 Sıralamayı Kaydet</button>
						<button type="button" onclick="resetOrder()" style="background:#6c757d;">⟳ Sıfırla</button>
					</div>
				</form>
			</div>
		</div>
		
		<div class="add-item-area">
			<div class="add-item-header">
				➕ Yeni Menü Öğesi Ekle
			</div>
			<div class="add-item-container">
				<form method="POST" action="/df-admin/menus/add-item/<?php echo $menu['id']; ?>" id="add-item-form">
					<div class="form-group">
						<label>Başlık:</label>
						<input type="text" name="title" required>
					</div>
					<div class="form-group">
						<label>URL:</label>
						<input type="text" name="url" placeholder="https:// veya /sayfa" required>
					</div>
					<div class="form-group">
						<label>Menü Tipi:</label>
						<select name="menu_type">
							<option value="default">Normal Menü</option>
							<option value="dropdown">Dropdown Menü</option>
						</select>
					</div>
					<div class="form-group">
						<label>İkon (FontAwesome):</label>
						<input type="text" name="icon" placeholder="fa-home">
					</div>
					<div class="form-group">
						<label>Üst Menü:</label>
						<select name="parent_id">
							<option value="0">Ana Menü (Kök)</option>
							<?php echo renderParentOptions($items); ?>
						</select>
					</div>
					
					<button type="submit">➕ Menü Öğesi Ekle</button>
				</form>
			</div>
		</div>
	</div>
	
	<div id="edit-modal" class="edit-modal">
		<div class="edit-modal-content">
			<div class="edit-modal-header">
				<strong>✏️ Menü Öğesini Düzenle</strong>
			</div>
			<div class="form-group">
				<label>Başlık:</label>
				<input type="text" id="edit-title" class="edit-input">
			</div>
			<div class="form-group">
				<label>URL:</label>
				<input type="text" id="edit-url" class="edit-input">
			</div>
			<div class="edit-modal-buttons">
				<button onclick="saveEdit()">Kaydet</button>
				<button onclick="closeEditModal()" style="background:#6c757d;">İptal</button>
			</div>
		</div>
	</div>
	
	<p style="margin-top: 20px;"><a href="/df-admin/menus">← Menülere Dön</a></p>
	
	<script>
	let currentEditItem = null;
	let dragSrcItem = null;
	let dropTargetItem = null;
	
	function collectOrderIds() {
		const items = [];
		
		function collectRecursive(element, parentId = 0) {
			const children = element.children;
			for (let i = 0; i < children.length; i++) {
				const child = children[i];
				if (child.classList && child.classList.contains('menu-item-wrapper')) {
					const menuItem = child.querySelector('.menu-item');
					if (menuItem) {
						const itemId = menuItem.getAttribute('data-id');
						if (itemId) {
							items.push({
								id: itemId,
								parent_id: parentId
							});
						}
					}
					const submenu = child.querySelector('.submenu-list');
					if (submenu) {
						collectRecursive(submenu, menuItem.getAttribute('data-id'));
					}
				}
			}
		}
		
		const menuList = document.getElementById('menu-list');
		if (menuList) {
			collectRecursive(menuList, 0);
		}
		
		const orderInput = document.getElementById('items-order-input');
		if (orderInput) {
			orderInput.value = JSON.stringify(items);
			console.log('Sıralama kaydedildi:', items);
		}
	}
	
	function saveOrder() {
		collectOrderIds();
		document.getElementById('menu-form').submit();
	}
	
	function resetOrder() {
		if (confirm('Yapılan değişiklikler kaybolacak. Devam etmek istiyor musunuz?')) {
			location.reload();
		}
	}
	
	function openEditModal(itemId, title, url) {
		currentEditItem = itemId;
		document.getElementById('edit-title').value = title;
		document.getElementById('edit-url').value = url;
		document.getElementById('edit-modal').style.display = 'flex';
	}
	
	function closeEditModal() {
		document.getElementById('edit-modal').style.display = 'none';
		currentEditItem = null;
	}
	
	function saveEdit() {
		if (currentEditItem) {
			const newTitle = document.getElementById('edit-title').value;
			const newUrl = document.getElementById('edit-url').value;
			fetch('/df-admin/menus/update-item', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: 'id=' + currentEditItem + '&title=' + encodeURIComponent(newTitle) + '&url=' + encodeURIComponent(newUrl)
			}).then(response => {
				if (response.ok) location.reload();
				else alert('Güncelleme başarısız oldu');
			});
		}
		closeEditModal();
	}
	
	function handleDragStart(e) {
		dragSrcItem = this.closest('.menu-item-wrapper');
		if (!dragSrcItem) return;
		e.dataTransfer.effectAllowed = 'move';
		this.classList.add('dragging');
	}
	
	function handleDragOver(e) {
		e.preventDefault();
		const targetWrapper = this.closest('.menu-item-wrapper');
		if (!targetWrapper || targetWrapper === dragSrcItem) return;
		
		const rect = this.getBoundingClientRect();
		const mouseY = e.clientY;
		const relativeY = (mouseY - rect.top) / rect.height;
		
		dropTargetItem = targetWrapper;
		
		document.querySelectorAll('.menu-item').forEach(item => {
			item.classList.remove('drop-target-before', 'drop-target-after', 'drop-target-inside');
		});
		
		if (relativeY < 0.3) {
			this.classList.add('drop-target-before');
		} else if (relativeY > 0.7) {
			this.classList.add('drop-target-after');
		} else {
			this.classList.add('drop-target-inside');
		}
	}
	
	function handleDragLeave(e) {
		this.classList.remove('drop-target-before', 'drop-target-after', 'drop-target-inside');
	}
	
	function handleDrop(e) {
		e.preventDefault();
		if (!dragSrcItem || !dropTargetItem) return;
		
		const dropClass = this.classList.contains('drop-target-before') ? 'before' :
						 this.classList.contains('drop-target-after') ? 'after' : 'inside';
		
		document.querySelectorAll('.menu-item').forEach(item => {
			item.classList.remove('drop-target-before', 'drop-target-after', 'drop-target-inside');
		});
		
		if (dropClass === 'before') {
			dropTargetItem.parentNode.insertBefore(dragSrcItem, dropTargetItem);
		} else if (dropClass === 'after') {
			if (dropTargetItem.nextSibling) {
				dropTargetItem.parentNode.insertBefore(dragSrcItem, dropTargetItem.nextSibling);
			} else {
				dropTargetItem.parentNode.appendChild(dragSrcItem);
			}
		} else if (dropClass === 'inside') {
			let submenuList = dropTargetItem.querySelector('.submenu-list');
			if (!submenuList) {
				submenuList = document.createElement('ul');
				submenuList.className = 'submenu-list';
				dropTargetItem.appendChild(submenuList);
			}
			submenuList.appendChild(dragSrcItem);
		}
		
		collectOrderIds();
	}
	
	function handleDragEnd(e) {
		dragSrcItem = null;
		dropTargetItem = null;
		document.querySelectorAll('.menu-item').forEach(item => {
			item.classList.remove('drop-target-before', 'drop-target-after', 'drop-target-inside', 'dragging');
		});
	}
	
	function initDragDrop() {
		document.querySelectorAll('.menu-item').forEach(item => {
			item.setAttribute('draggable', 'true');
			item.addEventListener('dragstart', handleDragStart);
			item.addEventListener('dragover', handleDragOver);
			item.addEventListener('dragleave', handleDragLeave);
			item.addEventListener('drop', handleDrop);
			item.addEventListener('dragend', handleDragEnd);
		});
	}
	
	document.addEventListener('DOMContentLoaded', function() {
		initDragDrop();
		collectOrderIds();
		
		const saveBtn = document.getElementById('save-order-btn');
		if (saveBtn) {
			saveBtn.addEventListener('click', function(e) {
				e.preventDefault();
				saveOrder();
			});
		}
	});
	</script>
</body>
</html>

<?php
function renderMenuItems($items, $menuId, $level = 0) {
	if (empty($items)) return '';
	$html = '';
	foreach ($items as $item) {
		$typeBadge = '';
		if ($item['menu_type'] == 'dropdown') {
			$typeBadge = '<span class="menu-item-badge badge-dropdown">DROPDOWN</span>';
		}
		
		$indent = $level > 0 ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) : '';
		
		$html .= '<li class="menu-item-wrapper">';
		$html .= '<div class="menu-item" data-id="' . $item['id'] . '">';
		$html .= '<div class="menu-item-content">';
		$html .= '<div class="menu-item-info">';
		$html .= '<span class="drag-handle">⋮⋮</span>';
		$html .= '<span class="menu-item-title">' . $indent . htmlspecialchars($item['title']) . '</span>';
		$html .= '<span class="menu-item-url">(' . htmlspecialchars($item['url']) . ')</span>';
		$html .= $typeBadge;
		$html .= '</div>';
		$html .= '<div class="menu-item-actions">';
		$html .= '<a href="#" onclick="openEditModal(\'' . $item['id'] . '\', \'' . addslashes($item['title']) . '\', \'' . addslashes($item['url']) . '\')">✏️</a>';
		$html .= '<a href="/df-admin/menus/delete-item/' . $menuId . '/' . $item['id'] . '" class="delete-btn" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')">🗑️</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		
		if (isset($item['children']) && is_array($item['children']) && !empty($item['children'])) {
			$html .= '<ul class="submenu-list">';
			$html .= renderMenuItems($item['children'], $menuId, $level + 1);
			$html .= '</ul>';
		}
		$html .= '</li>';
	}
	return $html;
}

function renderParentOptions($items, $level = 0) {
	$html = '';
	foreach ($items as $item) {
		$indent = str_repeat('—', $level + 1);
		$html .= '<option value="' . $item['id'] . '">' . $indent . ' ' . htmlspecialchars($item['title']) . '</option>';
		if (isset($item['children']) && is_array($item['children']) && !empty($item['children'])) {
			$html .= renderParentOptions($item['children'], $level + 1);
		}
	}
	return $html;
}
?>