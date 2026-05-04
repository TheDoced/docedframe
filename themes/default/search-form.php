<form action="/arama" method="GET" class="search-form">
	<input type="text" name="s" placeholder="Ara..." value="<?php echo htmlspecialchars($_GET['s'] ?? ''); ?>">
	<button type="submit">🔍 Ara</button>
</form>