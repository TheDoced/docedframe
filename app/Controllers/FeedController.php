<?php

/**
 * DocedFrame
 * FeedController.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;

class FeedController extends Controller
{
	public function rss()
	{
		$postModel = new Post();
		$posts = $postModel->getPublished();
		
		$siteUrl = get_option('site_url', '');
		$siteName = get_option('site_name', 'DocedFrame');
		$siteDescription = get_option('site_description', '');
		
		header('Content-Type: application/rss+xml; charset=utf-8');
		
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';
		echo '<channel>';
		echo '<title>' . htmlspecialchars($siteName) . '</title>';
		echo '<link>' . htmlspecialchars($siteUrl) . '</link>';
		echo '<description>' . htmlspecialchars($siteDescription) . '</description>';
		echo '<language>tr</language>';
		echo '<atom:link href="' . htmlspecialchars($siteUrl) . '/feed/rss" rel="self" type="application/rss+xml"/>';
		
		foreach ($posts as $post) {
			$postUrl = $siteUrl . '/yazi/' . $post['slug'];
			$pubDate = date('D, d M Y H:i:s O', strtotime($post['created_at']));
			$description = htmlspecialchars(substr(strip_tags($post['content']), 0, 500));
			
			echo '<item>';
			echo '<title>' . htmlspecialchars($post['title']) . '</title>';
			echo '<link>' . htmlspecialchars($postUrl) . '</link>';
			echo '<guid>' . htmlspecialchars($postUrl) . '</guid>';
			echo '<pubDate>' . $pubDate . '</pubDate>';
			echo '<description><![CDATA[' . $description . ']]></description>';
			echo '</item>';
		}
		
		echo '</channel>';
		echo '</rss>';
		exit;
	}
}