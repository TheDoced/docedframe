<?php

/**
 * DocedFrame
 * helpers.php
 * Versiyon: 1.0
 * Tarih: 03.05.2026
 */

use App\Models\Option;

function get_post_image($postId)
{
    // İleride medya yöneticisinden çekilecek
    return 'https://placehold.co/800x500/e2e8f0/475569?text=DocedFrame';
}

function get_template_directory_uri()
{
	return '/themes/default';
}

function home_url()
{
	return get_option('site_url', '');
}

function get_option($key, $default = null)
{
	$option = new Option();
	$value = $option->get($key);
	
	if ($value === null) {
		return $default;
	}
	
	return $value;
}

function set_option($key, $value)
{
	$option = new Option();
	return $option->set($key, $value);
}

function add_action($hook, $callback, $priority = 10)
{
	\Core\Hook\HookManager::addAction($hook, $callback, $priority);
}

function do_action($hook, ...$args)
{
	\Core\Hook\HookManager::doAction($hook, ...$args);
}

function add_filter($hook, $callback, $priority = 10)
{
	\Core\Hook\HookManager::addFilter($hook, $callback, $priority);
}

function apply_filters($hook, $value, ...$args)
{
	return \Core\Hook\HookManager::applyFilters($hook, $value, ...$args);
}

function cache($key = null, $ttl = 3600)
{
	static $cache = null;
	
	if ($cache === null) {
		$cache = new \Core\Cache\FileCache($ttl);
	}
	
	if ($key === null) {
		return $cache;
	}
	
	return $cache;
}

function cache_remember($key, $callback, $ttl = 3600)
{
	return cache()->remember($key, $callback, $ttl);
}

function cache_clear()
{
	return cache()->clear();
}

function current_user_can($capability)
{
	return \Core\Auth\Auth::can($capability);
}

function is_admin()
{
	return \Core\Auth\Auth::check() && \Core\Auth\Auth::can('manage_options');
}

function get_post_link($post)
{
	$permalinkStructure = get_option('permalink_structure', 'simple');
	$siteUrl = get_option('site_url', '');
	
	switch ($permalinkStructure) {
		case 'simple':
			return $siteUrl . '/?p=' . $post['id'];
			
		case '/%year%/%month%/%slug%':
			$year = date('Y', strtotime($post['created_at']));
			$month = date('m', strtotime($post['created_at']));
			return $siteUrl . '/' . $year . '/' . $month . '/' . $post['slug'];
			
		case '/%category%/%slug%':
			$category = get_post_category($post['id']);
			return $siteUrl . '/' . $category . '/' . $post['slug'];
			
		case '/yazi/%slug%':
		default:
			return $siteUrl . '/yazi/' . $post['slug'];
	}
}

function get_post_category($postId)
{
	try {
		$pdo = \Core\Database\Connection::getInstance()->getPdo();
		$stmt = $pdo->prepare("
			SELECT t.slug FROM terms t
			INNER JOIN term_relationships tr ON t.id = tr.term_id
			WHERE tr.post_id = :post_id AND t.taxonomy = 'category'
			LIMIT 1
		");
		$stmt->execute(['post_id' => $postId]);
		$result = $stmt->fetch();
		return $result ? $result['slug'] : 'genel';
	} catch (Exception $e) {
		return 'genel';
	}
}