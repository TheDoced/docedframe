<?php

/**
 * Plugin Name: DocedFrame SEO
 * Description: SEO optimizasyonu için meta tag, sitemap ve robots.txt yönetimi
 * Version: 1.0
 * Author: DocedFrame
 */

namespace Plugin\Seo;

class Seo
{
	public static function activate()
	{
		self::createTables();
		self::addDefaultOptions();
	}
	
	public static function deactivate()
	{
		// Deaktivasyon işlemleri (opsiyonel)
	}

	public static function boot()
	{
		add_action('admin_menu', [self::class, 'addAdminMenu']);
		add_action('admin_post_save_seo', [self::class, 'saveSeoSettings']);
		add_action('admin_post_save_post_seo', [self::class, 'savePostSeo']);
		add_action('wp_head', [self::class, 'outputMetaTags']);
		add_action('wp_head', [self::class, 'outputFavicon']);
		add_action('wp_head', [self::class, 'loadFrontendAssets']);
		add_action('admin_head', [self::class, 'loadAdminAssets']);
		add_filter('the_content', [self::class, 'addReadingTime'], 10);
		add_action('init', [self::class, 'addRoutes']);
	}

	public static function loadAdminAssets()
	{
		$cssFile = '/plugins/seo/assets/css/admin.css';
		if (file_exists(__DIR__ . '/assets/css/admin.css')) {
			echo '<link rel="stylesheet" href="' . $cssFile . '">';
		}
	}
	
	public static function loadFrontendAssets()
	{
		$cssFile = '/plugins/seo/assets/css/frontend.css';
		if (file_exists(__DIR__ . '/assets/css/frontend.css')) {
			echo '<link rel="stylesheet" href="' . $cssFile . '">';
		}
	}
	
	public static function addAdminMenu()
	{
		add_action('admin_page_seo', [self::class, 'renderSeoPage']);
		add_action('admin_page_seo_sitemap', [self::class, 'renderSitemapPage']);
		add_action('admin_page_seo_robots', [self::class, 'renderRobotsPage']);
	}
	
	public static function renderSeoPage()
	{
		// Session başlat (eğer başlatılmadıysa)
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		
		$message = $_SESSION['seo_message'] ?? '';
		unset($_SESSION['seo_message']);
		
		$generalSettings = get_option('seo_general', '');
		$socialSettings = get_option('seo_social', '');
		
		$general = $generalSettings ? json_decode($generalSettings, true) : [];
		$social = $socialSettings ? json_decode($socialSettings, true) : [];
		
		?>
		<div class="wrap">
			<h1>SEO Ayarları</h1>
			
			<?php if (!empty($message)): ?>
			<div class="notice notice-success">
				<p><?php echo htmlspecialchars($message); ?></p>
			</div>
			<?php endif; ?>
			
			<form method="POST" action="/df-admin/admin-post">
				<input type="hidden" name="action" value="save_seo">
				
				<h2>Genel Ayarlar</h2>
				<table class="form-table">
					<tr>
						<th>Ana Sayfa Başlığı</th>
						<td><input type="text" name="home_title" value="<?php echo htmlspecialchars($general['home_title'] ?? ''); ?>" style="width: 100%;"></td>
					</tr>
					<tr>
						<th>Ana Sayfa Açıklaması</th>
						<td><textarea name="home_description" rows="3" style="width: 100%;"><?php echo htmlspecialchars($general['home_description'] ?? ''); ?></textarea></td>
					</tr>
					<tr>
						<th>Ana Sayfa Anahtar Kelimeler</th>
						<td><input type="text" name="home_keywords" value="<?php echo htmlspecialchars($general['home_keywords'] ?? ''); ?>" style="width: 100%;"></td>
					</tr>
				</table>
				
				<h2>Sosyal Medya Ayarları</h2>
				<table class="form-table">
					<tr>
						<th>Facebook App ID</th>
						<td><input type="text" name="fb_app_id" value="<?php echo htmlspecialchars($social['fb_app_id'] ?? ''); ?>"><td>
					</tr>
					<tr>
						<th>Twitter Site</th>
						<td><input type="text" name="twitter_site" value="<?php echo htmlspecialchars($social['twitter_site'] ?? ''); ?>"></td>
					</tr>
					<tr>
						<th>OG Image</th>
						<td><input type="text" name="og_image" value="<?php echo htmlspecialchars($social['og_image'] ?? ''); ?>" placeholder="/uploads/image.jpg"></td>
					</tr>
				</table>
				
				<p><button type="submit">Kaydet</button></p>
			</form>
		</div>
		<?php
	}
	
	public static function renderSitemapPage()
	{
		?>
		<div class="wrap">
			<h1>Sitemap Ayarları</h1>
			
			<form method="POST" action="/df-admin/admin-post">
				<input type="hidden" name="action" value="save_seo">
				<input type="hidden" name="sitemap" value="1">
				
				<p>Sitemap URL: <a href="/sitemap.xml" target="_blank"><?php echo get_option('site_url', ''); ?>/sitemap.xml</a></p>
				
				<div>
					<label>
						<input type="checkbox" name="sitemap_posts" value="1" <?php echo get_option('sitemap_posts', '1') == '1' ? 'checked' : ''; ?>>
						Yazıları Sitemap'e Ekle
					</label>
				</div>
				<div>
					<label>
						<input type="checkbox" name="sitemap_pages" value="1" <?php echo get_option('sitemap_pages', '1') == '1' ? 'checked' : ''; ?>>
						Sayfaları Sitemap'e Ekle
					</label>
				</div>
				
				<p><button type="submit">Kaydet</button></p>
			</form>
		</div>
		<?php
	}
	
	public static function renderRobotsPage()
	{
		$currentRobots = get_option('robots_txt', '');
		?>
		<div class="wrap">
			<h1>Robots.txt Düzenleyici</h1>
			
			<form method="POST" action="/df-admin/admin-post">
				<input type="hidden" name="action" value="save_seo">
				<input type="hidden" name="robots" value="1">
				
				<textarea name="robots_content" rows="15" style="width: 100%; font-family: monospace;"><?php echo htmlspecialchars($currentRobots); ?></textarea>
				
				<p><button type="submit">Kaydet</button></p>
			</form>
			
			<h3>Varsayılan Robots.txt</h3>
			<pre>
User-agent: *
Allow: /
Disallow: /df-admin/
Disallow: /admin/
Sitemap: <?php echo get_option('site_url', ''); ?>/sitemap.xml
			</pre>
		</div>
		<?php
	}
	
	public static function saveSeoSettings()
	{
		if (isset($_POST['sitemap'])) {
			set_option('sitemap_posts', $_POST['sitemap_posts'] ?? '0');
			set_option('sitemap_pages', $_POST['sitemap_pages'] ?? '0');
			$_SESSION['seo_message'] = 'Sitemap ayarları kaydedildi.';
		} elseif (isset($_POST['robots'])) {
			set_option('robots_txt', $_POST['robots_content'] ?? '');
			$_SESSION['seo_message'] = 'Robots.txt ayarları kaydedildi.';
		} else {
			$general = [
				'home_title' => $_POST['home_title'] ?? '',
				'home_description' => $_POST['home_description'] ?? '',
				'home_keywords' => $_POST['home_keywords'] ?? ''
			];
			
			$social = [
				'fb_app_id' => $_POST['fb_app_id'] ?? '',
				'twitter_site' => $_POST['twitter_site'] ?? '',
				'og_image' => $_POST['og_image'] ?? ''
			];
			
			set_option('seo_general', json_encode($general));
			set_option('seo_social', json_encode($social));
			$_SESSION['seo_message'] = 'SEO ayarları kaydedildi.';
		}
		
		header('Location: /df-admin/seo');
		exit;
	}
	
	public static function savePostSeo()
	{
		$postId = $_POST['post_id'] ?? 0;
		$postType = $_POST['post_type'] ?? 'post';
		
		$seoModel = new \App\Models\Seo();
		$seoModel->saveMeta($postId, $postType, [
			'meta_title' => $_POST['meta_title'] ?? '',
			'meta_description' => $_POST['meta_description'] ?? '',
			'meta_keywords' => $_POST['meta_keywords'] ?? ''
		]);
		
		header('Location: /df-admin/posts/edit/' . $postId);
		exit;
	}
	
	public static function outputMetaTags()
	{
		$currentUrl = $_SERVER['REQUEST_URI'];
		$title = get_option('site_name', '');
		$description = get_option('site_description', '');
		$keywords = '';
		$ogImage = '';
		
		if ($currentUrl == '/' || $currentUrl == '/index.php') {
			$seoGeneral = get_option('seo_general', '');
			if ($seoGeneral) {
				$general = json_decode($seoGeneral, true);
				$title = $general['home_title'] ?: $title;
				$description = $general['home_description'] ?: $description;
				$keywords = $general['home_keywords'] ?: '';
			}
		} elseif (preg_match('/\/yazi\/(.+)/', $currentUrl, $matches)) {
			$slug = $matches[1];
			$pdo = \Core\Database\Connection::getInstance()->getPdo();
			$stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug");
			$stmt->execute(['slug' => $slug]);
			$post = $stmt->fetch();
			
			if ($post) {
				$title = $post['title'];
				$description = substr(strip_tags($post['content']), 0, 160);
				
				$seoModel = new \App\Models\Seo();
				$seoMeta = $seoModel->getMeta($post['id'], $post['type']);
				if ($seoMeta) {
					$title = $seoMeta['meta_title'] ?: $title;
					$description = $seoMeta['meta_description'] ?: $description;
					$keywords = $seoMeta['meta_keywords'] ?: '';
				}
			}
		}
		
		$socialSettings = get_option('seo_social', '');
		if ($socialSettings) {
			$social = json_decode($socialSettings, true);
			$ogImage = $social['og_image'] ?? '';
		}
		
		echo "<title>" . htmlspecialchars($title) . "</title>\n";
		echo "<meta name=\"description\" content=\"" . htmlspecialchars($description) . "\">\n";
		if ($keywords) {
			echo "<meta name=\"keywords\" content=\"" . htmlspecialchars($keywords) . "\">\n";
		}
		echo "<meta property=\"og:title\" content=\"" . htmlspecialchars($title) . "\">\n";
		echo "<meta property=\"og:description\" content=\"" . htmlspecialchars($description) . "\">\n";
		echo "<meta property=\"og:url\" content=\"" . get_option('site_url', '') . $currentUrl . "\">\n";
		echo "<meta property=\"og:type\" content=\"website\">\n";
		if ($ogImage) {
			echo "<meta property=\"og:image\" content=\"" . get_option('site_url', '') . $ogImage . "\">\n";
		}
		
		$fbAppId = $social['fb_app_id'] ?? '';
		if ($fbAppId) {
			echo "<meta property=\"fb:app_id\" content=\"" . $fbAppId . "\">\n";
		}
		
		$twitterSite = $social['twitter_site'] ?? '';
		if ($twitterSite) {
			echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
			echo "<meta name=\"twitter:site\" content=\"" . $twitterSite . "\">\n";
		}
	}
	
	public static function outputFavicon()
	{
		$favicon = get_option('site_favicon', '');
		if ($favicon) {
			echo "<link rel=\"icon\" type=\"image/x-icon\" href=\"" . $favicon . "\">\n";
		}
	}
	
	public static function addReadingTime($content)
	{
		$wordCount = str_word_count(strip_tags($content));
		$readingTime = ceil($wordCount / 200);
		
		if ($readingTime > 0) {
			$readingTimeHtml = "<p class=\"reading-time\">📖 Okuma süresi: yaklaşık {$readingTime} dakika</p>";
			return $readingTimeHtml . $content;
		}
		
		return $content;
	}
	
	public static function addRoutes()
	{
		global $router;
		if ($router) {
			// Sitemap ve robots
			$router->get('/sitemap.xml', function() {
				self::generateSitemap();
			});
			$router->get('/robots.txt', function() {
				self::generateRobots();
			});
			
			// Admin SEO sayfaları
			$router->get('/df-admin/seo', function() {
				self::renderSeoPage();
			});
			$router->get('/df-admin/seo/sitemap', function() {
				self::renderSitemapPage();
			});
			$router->get('/df-admin/seo/robots', function() {
				self::renderRobotsPage();
			});
			$router->post('/df-admin/admin-post', function() {
				$action = $_POST['action'] ?? '';
				if ($action == 'save_seo') {
					self::saveSeoSettings();
				} elseif ($action == 'save_post_seo') {
					self::savePostSeo();
				}
			});
		}
	}
	
	private static function generateSitemap()
	{
		header('Content-Type: application/xml');
		
		$urls = [];
		$siteUrl = get_option('site_url', '');
		
		$urls[] = ['loc' => $siteUrl . '/', 'priority' => 1.0];
		
		if (get_option('sitemap_posts', '1') == '1') {
			$pdo = \Core\Database\Connection::getInstance()->getPdo();
			$stmt = $pdo->query("SELECT slug, created_at FROM posts WHERE type = 'post' AND status = 'publish'");
			$posts = $stmt->fetchAll();
			foreach ($posts as $post) {
				$urls[] = [
					'loc' => $siteUrl . '/yazi/' . $post['slug'],
					'lastmod' => $post['created_at'],
					'priority' => 0.8
				];
			}
		}
		
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ($urls as $url) {
			echo '<url>';
			echo '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
			if (isset($url['lastmod'])) {
				echo '<lastmod>' . date('Y-m-d', strtotime($url['lastmod'])) . '</lastmod>';
			}
			echo '<priority>' . $url['priority'] . '</priority>';
			echo '</url>';
		}
		echo '</urlset>';
		exit;
	}
	
	private static function generateRobots()
	{
		header('Content-Type: text/plain');
		
		$savedRobots = get_option('robots_txt', '');
		if ($savedRobots) {
			echo $savedRobots;
		} else {
			echo "User-agent: *\n";
			echo "Allow: /\n";
			echo "Disallow: /df-admin/\n";
			echo "Disallow: /admin/\n";
			echo "Sitemap: " . get_option('site_url', '') . "/sitemap.xml\n";
		}
		exit;
	}
	
	private static function createTables()
	{
		$pdo = \Core\Database\Connection::getInstance()->getPdo();
		
		$sql = "CREATE TABLE IF NOT EXISTS seo_meta (
			id INT AUTO_INCREMENT PRIMARY KEY,
			object_id INT NOT NULL,
			object_type VARCHAR(50) NOT NULL,
			meta_title VARCHAR(255),
			meta_description TEXT,
			meta_keywords VARCHAR(255),
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			UNIQUE KEY unique_object (object_id, object_type)
		)";
		$pdo->exec($sql);
	}
	
	private static function addDefaultOptions()
	{
		set_option('sitemap_posts', '1');
		set_option('sitemap_pages', '1');
		
		$defaultRobots = "User-agent: *\nAllow: /\nDisallow: /df-admin/\nDisallow: /admin/\nSitemap: " . get_option('site_url', '') . "/sitemap.xml";
		set_option('robots_txt', $defaultRobots);
	}
}