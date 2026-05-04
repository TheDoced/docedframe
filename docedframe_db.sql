-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2026 at 02:27 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docedframe_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `author_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author_name`, `author_email`, `content`, `status`, `created_at`) VALUES
(1, 1, 'asd', 'admin@admin.com', 'TEstir lo haberin olsun mk', 'approved', '2026-05-03 02:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `hero_sections`
--

CREATE TABLE `hero_sections` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'static',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `button_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_items` text COLLATE utf8mb4_unicode_ci,
  `search_placeholder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_sections`
--

INSERT INTO `hero_sections` (`id`, `name`, `type`, `title`, `subtitle`, `button_text`, `button_url`, `image`, `slider_items`, `search_placeholder`, `status`, `created_at`) VALUES
(1, 'admin', 'search', '<span>Modern Tema</span> ve Şablonları Keşfedin', '10.000+ kaliteli tema, şablon ve dijital ürün. İhtiyacınız olanı bulun.', '', '', '', '', 'Tema, şablon veya kategori ara...', 1, '2026-05-03 07:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `alt_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `filename`, `original_name`, `path`, `mime_type`, `size`, `alt_text`, `created_by`, `created_at`) VALUES
(2, '69f6b1bab1207.png', 'TD.png', '/uploads/69f6b1bab1207.png', 'image/png', 126595, NULL, 1, '2026-05-03 02:23:54'),
(3, '69f6b1be41357.png', 'TD-removebg-preview.png', '/uploads/69f6b1be41357.png', 'image/png', 120622, NULL, 1, '2026-05-03 02:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `location`, `created_at`) VALUES
(1, 'Ana Menü', 'ana-menu', 'primary', '2026-05-03 07:44:53');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int NOT NULL,
  `menu_id` int NOT NULL,
  `parent_id` int DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '_self',
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `menu_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `parent_id`, `title`, `url`, `target`, `icon`, `position`, `created_at`, `menu_type`) VALUES
(38, 1, 0, 'Ana Sayfa', '/', '_self', NULL, 0, '2026-05-03 08:05:01', 'default'),
(39, 1, 0, 'Hakkımızda', '/hakkimizda', '_self', NULL, 1, '2026-05-03 08:05:01', 'default'),
(40, 1, 0, 'İletişim', '/iletisim', '_self', NULL, 2, '2026-05-03 08:05:01', 'default'),
(41, 1, 0, 'Ürünler', '#', '_self', NULL, 3, '2026-05-03 08:05:01', 'dropdown'),
(42, 1, 41, 'Bilgisayar', '/bilgisayar', '_self', NULL, 5, '2026-05-03 08:05:01', 'default'),
(43, 1, 41, 'Telefon', '/telefon', '_self', NULL, 4, '2026-05-03 08:05:01', 'default'),
(44, 1, 41, 'Tablet', '/tablet', '_self', NULL, 7, '2026-05-03 08:05:01', 'default'),
(45, 1, 41, 'Hizmetler', '#', '_self', NULL, 6, '2026-05-03 08:05:01', 'mega');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int NOT NULL,
  `option_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `autoload` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'DocedFrame CMS', 1, '2026-05-03 02:03:57', '2026-05-03 02:03:57'),
(2, 'site_description', 'Güçlü ve esnek içerik yönetim sistemi', 1, '2026-05-03 02:03:57', '2026-05-03 02:03:57'),
(3, 'site_url', 'http://docedframe.td', 1, '2026-05-03 02:03:57', '2026-05-03 02:03:57'),
(4, 'active_theme', 'default', 1, '2026-05-03 02:32:36', '2026-05-03 02:32:36'),
(5, 'active_plugins', 'demo,shortcodes,seo', 1, '2026-05-03 02:44:06', '2026-05-03 23:15:14'),
(6, 'seo_general', '{\"home_title\":\"DocedFrame Ba\\u015fl\\u0131k\",\"home_description\":\"DocedFrame a\\u00e7\\u0131klama\",\"home_keywords\":\"DocedFrame,kelime,\"}', 1, '2026-05-03 03:03:06', '2026-05-03 03:03:06'),
(7, 'seo_social', '{\"fb_app_id\":\"\",\"twitter_site\":\"\",\"og_image\":\"\"}', 1, '2026-05-03 03:03:06', '2026-05-03 03:03:06'),
(8, 'sitemap_posts', '1', 1, '2026-05-03 03:03:33', '2026-05-03 03:03:33'),
(9, 'sitemap_pages', '1', 1, '2026-05-03 03:03:33', '2026-05-03 03:03:33'),
(10, 'robots_txt', 'asdasdasd', 1, '2026-05-03 03:03:47', '2026-05-03 03:03:47'),
(11, 'permalink_structure', '/%category%/%slug%', 1, '2026-05-03 04:45:34', '2026-05-03 22:56:37'),
(12, 'category_base', 'kategori', 1, '2026-05-03 04:46:42', '2026-05-03 04:46:42'),
(13, 'tag_base', 'etiket', 1, '2026-05-03 04:46:42', '2026-05-03 04:46:42'),
(14, 'social_login_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:43:24'),
(15, 'social_google_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(16, 'social_google_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(17, 'social_google_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(18, 'social_facebook_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(19, 'social_facebook_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(20, 'social_facebook_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(21, 'social_github_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(22, 'social_github_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(23, 'social_github_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(24, 'social_twitter_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(25, 'social_twitter_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(26, 'social_twitter_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(27, 'social_linkedin_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(28, 'social_linkedin_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(29, 'social_linkedin_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(30, 'social_microsoft_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(31, 'social_microsoft_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(32, 'social_microsoft_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(33, 'social_apple_enabled', '1', 1, '2026-05-03 23:19:45', '2026-05-03 23:20:09'),
(34, 'social_apple_client_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(35, 'social_apple_client_secret', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(36, 'social_apple_team_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(37, 'social_apple_key_id', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45'),
(38, 'social_apple_private_key', '', 1, '2026-05-03 23:19:45', '2026-05-03 23:19:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `author_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `type`, `status`, `author_id`, `created_at`, `updated_at`) VALUES
(1, 'İlk Yazım', 'ilk-yazim', 'Bu benim ilk yazım. DocedFrame harika çalışıyor.', 'Hoş geldiniz!', 'post', 'publish', 1, '2026-05-03 02:06:49', '2026-05-03 03:29:05'),
(2, 'Hakkımızda', 'hakkimizda', 'DocedFrame hakkında bilgiler.', 'DocedFrame nedir?', 'page', 'publish', 1, '2026-05-03 02:06:49', '2026-05-03 03:29:05'),
(4, 'Testo', 'testo', 'asdasdasda', NULL, 'post', 'publish', 1, '2026-05-03 02:20:12', '2026-05-03 03:29:05'),
(5, 'Shortcode Test', 'shortcode-test', '<h2>📅 Temel Shortcode\'lar</h2>\r\n<p>Yıl: [year]</p>\r\n<p>Site Adı: [site_name]</p>\r\n<p>Site URL: [site_url]</p>\r\n<p>Bugün: [current_date format=\"d.m.Y H:i:s\"]</p>\r\n\r\n<hr>\r\n\r\n<h2>🔘 Buton Shortcode</h2>\r\n[button url=\"https://docedframe.td\" text=\"Tıkla\" color=\"#0073aa\"]\r\n\r\n<hr>\r\n\r\n<h2>⚠️ Alert Shortcode\'ları</h2>\r\n[alert type=\"success\" message=\"✅ İşlem başarıyla tamamlandı!\"]\r\n\r\n[alert type=\"error\" message=\"❌ Bir hata oluştu!\"]\r\n\r\n[alert type=\"warning\" message=\"⚠️ Lütfen dikkat!\"]\r\n\r\n[alert type=\"info\" message=\"ℹ️ Bilgi mesajı\"]\r\n\r\n<hr>\r\n\r\n<h2>📦 Açılış-Kapanış Shortcode\'ları</h2>\r\n[success]✅ Bu bir başarı mesajıdır![/success]\r\n\r\n[error]❌ Bu bir hata mesajıdır![/error]\r\n\r\n[warning]⚠️ Bu bir uyarı mesajıdır![/warning]\r\n\r\n[info]ℹ️ Bu bir bilgi mesajıdır![/info]\r\n\r\n<hr>\r\n\r\n<h2>🍞 Breadcrumb</h2>\r\n[breadcrumb separator=\"/\" home=\"Anasayfa\"]\r\n\r\n<hr>\r\n\r\n<h2>📝 Son Yazılar</h2>\r\n[posts limit=\"3\"]\r\n\r\n<hr>\r\n\r\n<h2>🎨 Highlight</h2>\r\n<p>[highlight color=\"yellow\"]Bu metin vurgulanmıştır[/highlight]</p>\r\n\r\n<hr>\r\n\r\n<h2>💬 Tooltip</h2>\r\n<p>Bu bir [tooltip text=\"Açıklama metni\"]araç ipucu[/tooltip] örneğidir.</p>\r\n\r\n<hr>\r\n\r\n<h2>🔌 İframe</h2>\r\n[iframe src=\"https://www.youtube.com/embed/dQw4w9WgXcQ\" width=\"100%\" height=\"300\"]\r\n\r\n<hr>\r\n\r\n<h2>📊 Countdown</h2>\r\n<p>Yılbaşına kalan gün: [countdown date=\"2026-12-31\" format=\"days\"] gün</p>\r\n\r\n<hr>\r\n\r\n<h2>👤 Kullanıcı Bilgisi</h2>\r\n<p>Hoş geldiniz, [user_info field=\"display_name\"]</p>\r\n\r\n[login_form]\r\n\r\n<hr>\r\n\r\n<h2>🔗 Sosyal Linkler</h2>\r\n[social_links facebook=\"#\" twitter=\"#\" instagram=\"#\"]\r\n\r\n<hr>\r\n\r\n<h2>🎲 Rastgele Metin</h2>\r\n<p>Bugünün şanslı kelimesi: [random_text list=\"Gelişim,Başarı,Mutluluk,Huzur,Sevgi\"]</p>\r\n\r\n<hr>\r\n\r\n<h2>🐦 Twitter Paylaş</h2>\r\n[twitter_share text=\"DocedFrame CMS\" url=\"https://docedframe.td\"]\r\n\r\n<hr>\r\n\r\n<h2>📄 Kod Gösterimi</h2>\r\n[code language=\"php\"]\r\n&lt;?php\r\necho \"Merhaba DocedFrame!\";\r\n$site = get_option(\'site_name\');\r\n?>\r\n[/code]', NULL, 'post', 'publish', 1, '2026-05-03 04:15:54', '2026-05-03 04:26:42'),
(6, 'Hakkımızda', 'hakk-m-zda', '<main class=\"about-page\">\r\n		<!-- Hero Section -->\r\n		<section class=\"about-hero\">\r\n			<div class=\"about-hero-content\">\r\n				<div class=\"about-badge\">HAKKIMIZDA</div>\r\n				<h1 class=\"about-title\">Dijital Dünyada <span>İz Bırakan</span> Çözümler</h1>\r\n				<p class=\"about-description\">Doced UI olarak, modern web teknolojileri ile markaların dijital dönüşümüne liderlik ediyoruz.</p>\r\n			</div>\r\n		</section>\r\n\r\n		<!-- Story Section -->\r\n		<section class=\"story-section\">\r\n			<div class=\"container\">\r\n				<div class=\"story-grid\">\r\n					<div class=\"story-content\">\r\n						<div class=\"section-badge\">HİKAYEMİZ</div>\r\n						<h2>2020\'den Bugüne<br>Dijital Yolculuğumuz</h2>\r\n						<p>Doced UI, 2020 yılında bir grup yazılım geliştirici ve tasarımcı tarafından kuruldu. Amacımız, kaliteli ve erişilebilir dijital ürünleri herkesle buluşturmak.</p>\r\n						<p>Bugün, 50\'den fazla ülkeden 10.000\'den fazla mutlu müşteriye hizmet veriyor, 500\'den fazla premium tema ve şablon ile sektörde fark yaratıyoruz.</p>\r\n						<div class=\"story-stats\">\r\n							<div class=\"stat-item\">\r\n								<span class=\"stat-number\">5+</span>\r\n								<span class=\"stat-label\">Yıl Deneyim</span>\r\n							</div>\r\n							<div class=\"stat-item\">\r\n								<span class=\"stat-number\">10K+</span>\r\n								<span class=\"stat-label\">Mutlu Müşteri</span>\r\n							</div>\r\n							<div class=\"stat-item\">\r\n								<span class=\"stat-number\">500+</span>\r\n								<span class=\"stat-label\">Premium Tema</span>\r\n							</div>\r\n							<div class=\"stat-item\">\r\n								<span class=\"stat-number\">98%</span>\r\n								<span class=\"stat-label\">Memnuniyet</span>\r\n							</div>\r\n						</div>\r\n					</div>\r\n					<div class=\"story-image\">\r\n						<img src=\"https://placehold.co/600x500/e2e8f0/475569?text=Hikayemiz\" alt=\"About Us\">\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</section>\r\n\r\n		<!-- Mission & Vision -->\r\n		<section class=\"mission-section\">\r\n			<div class=\"container\">\r\n				<div class=\"mission-grid\">\r\n					<div class=\"mission-card\">\r\n						<div class=\"mission-icon\">🎯</div>\r\n						<h3>Misyonumuz</h3>\r\n						<p>İşletmelerin dijital dönüşümünü hızlandırmak, yenilikçi ve kullanıcı odaklı çözümler sunarak markaların hedeflerine ulaşmasına katkı sağlamak.</p>\r\n					</div>\r\n					<div class=\"mission-card\">\r\n						<div class=\"mission-icon\">👁️</div>\r\n						<h3>Vizyonumuz</h3>\r\n						<p>Dijital dünyada tercih edilen lider platform olmak, sürekli yenilik ve kalite anlayışıyla sektöre yön vermek.</p>\r\n					</div>\r\n					<div class=\"mission-card\">\r\n						<div class=\"mission-icon\">💎</div>\r\n						<h3>Değerlerimiz</h3>\r\n						<p>Kalite, güvenilirlik, yenilikçilik ve müşteri memnuniyeti bizim temel değerlerimizdir.</p>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</section>\r\n\r\n		<!-- Values Section -->\r\n		<section class=\"values-section\">\r\n			<div class=\"container\">\r\n				<div class=\"section-header\">\r\n					<div class=\"section-badge\">DEĞERLERİMİZ</div>\r\n					<h2>Bizi Başarıya Taşıyan<br>Değerlerimiz</h2>\r\n				</div>\r\n				<div class=\"values-grid\">\r\n					<div class=\"value-card\">\r\n						<div class=\"value-icon\">🔧</div>\r\n						<h4>Kalite</h4>\r\n						<p>Her ürünümüzde en yüksek kalite standartlarını hedefliyoruz.</p>\r\n					</div>\r\n					<div class=\"value-card\">\r\n						<div class=\"value-icon\">💡</div>\r\n						<h4>Yenilikçilik</h4>\r\n						<p>Değişen teknolojiye ayak uydurarak yenilikçi çözümler sunuyoruz.</p>\r\n					</div>\r\n					<div class=\"value-card\">\r\n						<div class=\"value-icon\">🤝</div>\r\n						<h4>Güvenilirlik</h4>\r\n						<p>Söz verdiğimiz her şeyi zamanında ve eksiksiz teslim ediyoruz.</p>\r\n					</div>\r\n					<div class=\"value-card\">\r\n						<div class=\"value-icon\">❤️</div>\r\n						<h4>Müşteri Odaklılık</h4>\r\n						<p>Müşterilerimizin ihtiyaçlarını her şeyin önünde tutuyoruz.</p>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</section>\r\n\r\n		<!-- Team Section -->\r\n		<section class=\"team-section\">\r\n			<div class=\"container\">\r\n				<div class=\"section-header\">\r\n					<div class=\"section-badge\">EKİBİMİZ</div>\r\n					<h2>Arkamızdaki Güçlü Ekip</h2>\r\n					<p>Tutkulu, yaratıcı ve deneyimli profesyonellerden oluşan ekibimiz</p>\r\n				</div>\r\n				<div class=\"team-grid\">\r\n					<div class=\"team-card\">\r\n						<div class=\"team-image\">\r\n							<img src=\"https://placehold.co/300x300/e2e8f0/475569?text=Ahmet\" alt=\"Team\">\r\n						</div>\r\n						<h4>Ahmet Yılmaz</h4>\r\n						<span>Kurucu & CEO</span>\r\n						<div class=\"team-social\">\r\n							<a href=\"#\">in</a>\r\n							<a href=\"#\">tw</a>\r\n							<a href=\"#\">ig</a>\r\n						</div>\r\n					</div>\r\n					<div class=\"team-card\">\r\n						<div class=\"team-image\">\r\n							<img src=\"https://placehold.co/300x300/e2e8f0/475569?text=Ayşe\" alt=\"Team\">\r\n						</div>\r\n						<h4>Ayşe Demir</h4>\r\n						<span>Baş Tasarımcı</span>\r\n						<div class=\"team-social\">\r\n							<a href=\"#\">in</a>\r\n							<a href=\"#\">tw</a>\r\n							<a href=\"#\">ig</a>\r\n						</div>\r\n					</div>\r\n					<div class=\"team-card\">\r\n						<div class=\"team-image\">\r\n							<img src=\"https://placehold.co/300x300/e2e8f0/475569?text=Mehmet\" alt=\"Team\">\r\n						</div>\r\n						<h4>Mehmet Kaya</h4>\r\n						<span>Lead Developer</span>\r\n						<div class=\"team-social\">\r\n							<a href=\"#\">in</a>\r\n							<a href=\"#\">tw</a>\r\n							<a href=\"#\">ig</a>\r\n						</div>\r\n					</div>\r\n					<div class=\"team-card\">\r\n						<div class=\"team-image\">\r\n							<img src=\"https://placehold.co/300x300/e2e8f0/475569?text=Selin\" alt=\"Team\">\r\n						</div>\r\n						<h4>Selin Çelik</h4>\r\n						<span>Proje Yöneticisi</span>\r\n						<div class=\"team-social\">\r\n							<a href=\"#\">in</a>\r\n							<a href=\"#\">tw</a>\r\n							<a href=\"#\">ig</a>\r\n						</div>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</section>\r\n\r\n		<!-- CTA Section -->\r\n		<section class=\"cta-section\">\r\n			<div class=\"container\">\r\n				<div class=\"cta-content\">\r\n					<h2>Hayallerinizdeki Projeyi<br>Gerçeğe Dönüştürelim</h2>\r\n					<p>Size özel çözümler ve profesyonel temalarla projenizi bir üst seviyeye taşıyın.</p>\r\n					<div class=\"cta-buttons\">\r\n						<a href=\"/contact\" class=\"btn-primary\">İletişime Geç</a>\r\n						<a href=\"/themes\" class=\"btn-outline\">Temaları Keşfet</a>\r\n					</div>\r\n				</div>\r\n			</div>\r\n		</section>\r\n	</main>', NULL, 'page', 'publish', 1, '2026-05-03 06:52:38', '2026-05-03 06:52:45');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capabilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `capabilities`, `created_at`) VALUES
(1, 'Yönetici', 'administrator', '{\"manage_options\":true,\"edit_posts\":true,\"delete_posts\":true,\"publish_posts\":true,\"upload_files\":true,\"manage_users\":true,\"manage_categories\":true,\"moderate_comments\":true,\"manage_themes\":true,\"manage_plugins\":true}', '2026-05-03 02:45:26'),
(2, 'Editör', 'editor', '{\"edit_posts\":true,\"delete_posts\":true,\"publish_posts\":true,\"upload_files\":true,\"moderate_comments\":true}', '2026-05-03 02:45:26'),
(3, 'Yazar', 'author', '{\"edit_posts\":true,\"publish_posts\":true,\"upload_files\":true}', '2026-05-03 02:45:26'),
(4, 'Abone', 'subscriber', '{}', '2026-05-03 02:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(3, 3, 4),
(4, 4, 2),
(5, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxonomy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'category',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES
(1, 'Teknoloji', 'teknoloji', 'category', '2026-05-03 02:16:11'),
(2, 'Yaşam', 'yasam', 'category', '2026-05-03 02:16:11'),
(3, 'Eğitim', 'egitim', 'category', '2026-05-03 02:16:11'),
(4, 'php', 'php', 'tag', '2026-05-03 02:16:11'),
(5, 'laravel', 'laravel', 'tag', '2026-05-03 02:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `term_relationships`
--

CREATE TABLE `term_relationships` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `term_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `twofa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twofa_enabled` tinyint DEFAULT '0',
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `display_name`, `status`, `created_at`, `twofa_secret`, `twofa_enabled`, `remember_token`) VALUES
(1, 'admin@docedframe.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin Kullanici', 1, '2026-05-03 01:56:56', NULL, 0, NULL),
(3, 'user@docedframe.com', '$2y$10$HKFqQ8ZItyjAJ1dNVgptGe48mL.P9uTquictSbpH9mjgZMjXyt5LK', 'Mehmet', 1, '2026-05-03 03:32:40', NULL, 0, NULL),
(4, 'mod@docedframe.com', '$2y$10$eUD6OUMiho/PWawBPvvV0uPUwlcBk24mH03.8a44jyMYMKnn81Dzi', 'Mehmet', 1, '2026-05-03 03:32:58', NULL, 0, NULL),
(5, 'yazar@docedframe.com', '$2y$10$6Ripdb.2OWDoY4JoFrX6Z.RFIELj8yBQ4meLYDqhRRaRPqDE7ElDa', 'Mehmet', 1, '2026-05-03 03:33:20', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `last_activity` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `hero_sections`
--
ALTER TABLE `hero_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_key` (`option_key`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_role` (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_provider_account` (`provider`,`provider_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_relation` (`post_id`,`term_id`),
  ADD KEY `term_id` (`term_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hero_sections`
--
ALTER TABLE `hero_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `term_relationships`
--
ALTER TABLE `term_relationships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD CONSTRAINT `social_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `term_relationships`
--
ALTER TABLE `term_relationships`
  ADD CONSTRAINT `term_relationships_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `term_relationships_ibfk_2` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
