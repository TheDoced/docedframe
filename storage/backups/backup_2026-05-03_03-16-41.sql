-- DocedFrame Database Backup
-- Oluşturulma: 2026-05-03 03:16:41

SET FOREIGN_KEY_CHECKS=0;

-- Tablo: comments
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comments` (`id`, `post_id`, `author_name`, `author_email`, `content`, `status`, `created_at`) VALUES ('1', '1', 'asd', 'admin@admin.com', 'TEstir lo haberin olsun mk', 'approved', '2026-05-03 05:27:38');

-- Tablo: media
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media` (`id`, `filename`, `original_name`, `path`, `mime_type`, `size`, `alt_text`, `created_by`, `created_at`) VALUES ('2', '69f6b1bab1207.png', 'TD.png', '/uploads/69f6b1bab1207.png', 'image/png', '126595', NULL, '1', '2026-05-03 05:23:54');
INSERT INTO `media` (`id`, `filename`, `original_name`, `path`, `mime_type`, `size`, `alt_text`, `created_by`, `created_at`) VALUES ('3', '69f6b1be41357.png', 'TD-removebg-preview.png', '/uploads/69f6b1be41357.png', 'image/png', '120622', NULL, '1', '2026-05-03 05:23:58');

-- Tablo: options
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` text COLLATE utf8mb4_unicode_ci,
  `autoload` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_key` (`option_key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('1', 'site_name', 'DocedFrame CMS', '1', '2026-05-03 05:03:57', '2026-05-03 05:03:57');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('2', 'site_description', 'Güçlü ve esnek içerik yönetim sistemi', '1', '2026-05-03 05:03:57', '2026-05-03 05:03:57');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('3', 'site_url', 'http://docedframe.td', '1', '2026-05-03 05:03:57', '2026-05-03 05:03:57');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('4', 'active_theme', 'default', '1', '2026-05-03 05:32:36', '2026-05-03 05:32:36');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('5', 'active_plugins', 'demo,seo', '1', '2026-05-03 05:44:06', '2026-05-03 05:57:37');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('6', 'seo_general', '{\"home_title\":\"DocedFrame Ba\\u015fl\\u0131k\",\"home_description\":\"DocedFrame a\\u00e7\\u0131klama\",\"home_keywords\":\"DocedFrame,kelime,\"}', '1', '2026-05-03 06:03:06', '2026-05-03 06:03:06');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('7', 'seo_social', '{\"fb_app_id\":\"\",\"twitter_site\":\"\",\"og_image\":\"\"}', '1', '2026-05-03 06:03:06', '2026-05-03 06:03:06');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('8', 'sitemap_posts', '1', '1', '2026-05-03 06:03:33', '2026-05-03 06:03:33');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('9', 'sitemap_pages', '1', '1', '2026-05-03 06:03:33', '2026-05-03 06:03:33');
INSERT INTO `options` (`id`, `option_key`, `option_value`, `autoload`, `created_at`, `updated_at`) VALUES ('10', 'robots_txt', 'asdasdasd', '1', '2026-05-03 06:03:47', '2026-05-03 06:03:47');

-- Tablo: posts
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `author_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `type`, `status`, `author_id`, `created_at`, `updated_at`) VALUES ('1', 'İlk Yazım', 'ilk-yazim', 'Bu benim ilk yazım. DocedFrame harika çalışıyor.', 'Hoş geldiniz!', 'post', 'publish', '1', '2026-05-03 05:06:49', '2026-05-03 05:06:49');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `type`, `status`, `author_id`, `created_at`, `updated_at`) VALUES ('2', 'Hakkımızda', 'hakkimizda', 'DocedFrame hakkında bilgiler.', 'DocedFrame nedir?', 'page', 'publish', '1', '2026-05-03 05:06:49', '2026-05-03 05:06:49');
INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `excerpt`, `type`, `status`, `author_id`, `created_at`, `updated_at`) VALUES ('4', 'Testo', 'testo', 'asdasdasda', NULL, 'post', 'draft', '1', '2026-05-03 05:20:12', '2026-05-03 05:20:12');

-- Tablo: role_user
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_role` (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `role_user` (`id`, `user_id`, `role_id`) VALUES ('1', '1', '1');

-- Tablo: roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capabilities` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `slug`, `capabilities`, `created_at`) VALUES ('1', 'Yönetici', 'administrator', '{\"manage_options\":true,\"edit_posts\":true,\"delete_posts\":true,\"publish_posts\":true,\"upload_files\":true,\"manage_users\":true}', '2026-05-03 05:45:26');
INSERT INTO `roles` (`id`, `name`, `slug`, `capabilities`, `created_at`) VALUES ('2', 'Editör', 'editor', '{\"edit_posts\":true,\"delete_posts\":true,\"publish_posts\":true,\"upload_files\":true}', '2026-05-03 05:45:26');
INSERT INTO `roles` (`id`, `name`, `slug`, `capabilities`, `created_at`) VALUES ('3', 'Yazar', 'author', '{\"edit_posts\":true,\"publish_posts\":true,\"upload_files\":true}', '2026-05-03 05:45:26');
INSERT INTO `roles` (`id`, `name`, `slug`, `capabilities`, `created_at`) VALUES ('4', 'Abone', 'subscriber', '{}', '2026-05-03 05:45:26');

-- Tablo: term_relationships
DROP TABLE IF EXISTS `term_relationships`;
CREATE TABLE `term_relationships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `term_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_relation` (`post_id`,`term_id`),
  KEY `term_id` (`term_id`),
  CONSTRAINT `term_relationships_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `term_relationships_ibfk_2` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `term_relationships` (`id`, `post_id`, `term_id`) VALUES ('1', '4', '2');
INSERT INTO `term_relationships` (`id`, `post_id`, `term_id`) VALUES ('2', '4', '5');

-- Tablo: terms
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxonomy` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'category',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES ('1', 'Teknoloji', 'teknoloji', 'category', '2026-05-03 05:16:11');
INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES ('2', 'Yaşam', 'yasam', 'category', '2026-05-03 05:16:11');
INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES ('3', 'Eğitim', 'egitim', 'category', '2026-05-03 05:16:11');
INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES ('4', 'php', 'php', 'tag', '2026-05-03 05:16:11');
INSERT INTO `terms` (`id`, `name`, `slug`, `taxonomy`, `created_at`) VALUES ('5', 'laravel', 'laravel', 'tag', '2026-05-03 05:16:11');

-- Tablo: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `email`, `password`, `display_name`, `status`, `created_at`) VALUES ('1', 'admin@docedframe.com', 'test123', 'Admin Kullanici', '1', '2026-05-03 04:56:56');

SET FOREIGN_KEY_CHECKS=1;
