<?php

/**
 * DocedFrame
 * index.php
 * Versiyon: 1.7
 * Tarih: 03.05.2026
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$requestUri = $_SERVER['REQUEST_URI'];
if (strpos($requestUri, '/themes/') === 0) {
    $file = __DIR__ . '/..' . $requestUri;
    if (file_exists($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ($ext == 'css') header('Content-Type: text/css');
        if ($ext == 'js') header('Content-Type: application/javascript');
        readfile($file);
        exit;
    }
}

// Permalink simple (?p=123) desteği - ROUTE TANIMLAMALARINDAN ÖNCE
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
	require_once __DIR__ . '/../core/Application.php';
	$app = Core\Application::getInstance();
	$controller = new App\Controllers\PostController();
	$controller->single($_GET['p']);
	exit;
}

require_once __DIR__ . '/../core/Application.php';

use Core\Application;

$app = Application::getInstance();

$router = $app->getRouter();

$router->get('/', 'HomeController@index');
$router->get('/hakkimizda', 'HomeController@about');
$router->get('/kullanicilar', 'UserController@index');
$router->get('/yazilar', 'PostController@index');
$router->get('/yazi/:slug', 'PostController@single');

$router->get('/df-admin', 'AdminController@login');
$router->get('/df-admin/dashboard', 'AdminController@dashboard');
$router->post('/df-admin/login', 'AdminController@doLogin');
$router->get('/df-admin/logout', 'AdminController@logout');

$router->get('/df-admin/posts', 'AdminPostController@index');
$router->get('/df-admin/posts/create', 'AdminPostController@create');
$router->post('/df-admin/posts/store', 'AdminPostController@store');
$router->get('/df-admin/posts/edit/:id', 'AdminPostController@edit');
$router->post('/df-admin/posts/update/:id', 'AdminPostController@update');
$router->get('/df-admin/posts/delete/:id', 'AdminPostController@delete');
$router->post('/df-admin/posts/bulk', 'AdminPostController@bulkAction');

$router->get('/df-admin/categories', 'AdminTermController@categories');
$router->post('/df-admin/categories/store', 'AdminTermController@storeCategory');
$router->get('/df-admin/categories/delete/:id', 'AdminTermController@deleteCategory');

$router->get('/df-admin/tags', 'AdminTermController@tags');
$router->post('/df-admin/tags/store', 'AdminTermController@storeTag');
$router->get('/df-admin/tags/delete/:id', 'AdminTermController@deleteTag');

$router->get('/df-admin/media', 'AdminMediaController@index');
$router->post('/df-admin/media/upload', 'AdminMediaController@upload');
$router->get('/df-admin/media/delete/:id', 'AdminMediaController@delete');
$router->post('/df-admin/media/ajax-upload', 'AdminMediaController@ajaxUpload');

$router->post('/yorum-ekle', 'PostController@addComment');

$router->get('/df-admin/comments', 'AdminCommentController@index');
$router->get('/df-admin/comments/approve/:id', 'AdminCommentController@approve');
$router->get('/df-admin/comments/delete/:id', 'AdminCommentController@delete');

$router->get('/df-admin/themes', 'AdminThemeController@index');
$router->get('/df-admin/themes/activate/:name', 'AdminThemeController@activate');

$router->get('/df-admin/plugins', 'AdminPluginController@index');
$router->get('/df-admin/plugins/activate/:name', 'AdminPluginController@activate');
$router->get('/df-admin/plugins/deactivate/:name', 'AdminPluginController@deactivate');

$router->get('/df-admin/users', 'AdminUserController@index');
$router->get('/df-admin/users/create', 'AdminUserController@create');
$router->post('/df-admin/users/store', 'AdminUserController@store');
$router->get('/df-admin/users/edit/:id', 'AdminUserController@edit');
$router->post('/df-admin/users/update/:id', 'AdminUserController@update');
$router->get('/df-admin/users/delete/:id', 'AdminUserController@delete');

$router->get('/arama', 'SearchController@index');
$router->get('/ajax/arama', 'SearchController@ajaxSearch');

$router->get('/df-admin/backup', 'AdminBackupController@index');
$router->get('/df-admin/backup/create', 'AdminBackupController@create');
$router->get('/df-admin/backup/download/:filename', 'AdminBackupController@download');
$router->get('/df-admin/backup/restore/:filename', 'AdminBackupController@restore');
$router->get('/df-admin/backup/delete/:filename', 'AdminBackupController@delete');

$router->get('/feed/rss', 'FeedController@rss');
$router->get('/rss.xml', 'FeedController@rss');

$router->get('/df-admin/cache', 'AdminCacheController@index');
$router->get('/df-admin/cache/clear', 'AdminCacheController@clear');

// Menu Routes
$router->get('/df-admin/menus', 'AdminMenuController@index');
$router->get('/df-admin/menus/create', 'AdminMenuController@create');
$router->post('/df-admin/menus/store', 'AdminMenuController@store');
$router->get('/df-admin/menus/edit/:id', 'AdminMenuController@edit');
$router->post('/df-admin/menus/update/:id', 'AdminMenuController@update');
$router->post('/df-admin/menus/add-item/:id', 'AdminMenuController@addItem');
$router->post('/df-admin/menus/update-items/:id', 'AdminMenuController@updateItems');
$router->post('/df-admin/menus/update-item', 'AdminMenuController@updateItem');
$router->get('/df-admin/menus/delete-item/:menuId/:itemId', 'AdminMenuController@deleteItem');
$router->get('/df-admin/menus/delete/:id', 'AdminMenuController@delete');

$router->get('/df-admin/settings', 'AdminSettingsController@index');
$router->post('/df-admin/settings/update', 'AdminSettingsController@update');
$router->get('/df-admin/settings/permalink', 'AdminSettingsController@permalink');
$router->post('/df-admin/settings/update-permalink', 'AdminSettingsController@updatePermalink');

$router->get('/df-admin/hero', 'AdminHeroController@index');
$router->get('/df-admin/hero/create', 'AdminHeroController@create');
$router->post('/df-admin/hero/store', 'AdminHeroController@store');
$router->get('/df-admin/hero/edit/:id', 'AdminHeroController@edit');
$router->post('/df-admin/hero/update/:id', 'AdminHeroController@update');
$router->get('/df-admin/hero/activate/:id', 'AdminHeroController@activate');
$router->get('/df-admin/hero/delete/:id', 'AdminHeroController@delete');

// Auth Routes
$router->get('/df-admin/login', 'AuthController@login');
$router->post('/df-admin/login', 'AuthController@doLogin');
$router->get('/df-admin/logout', 'AuthController@logout');
$router->get('/kayit', 'AuthController@register');
$router->post('/kayit', 'AuthController@doRegister');
$router->get('/sifremi-unuttum', 'AuthController@forgotPassword');
$router->post('/sifremi-unuttum', 'AuthController@doForgotPassword');
$router->get('/sifre-sifirla/:token', 'AuthController@resetPassword');
$router->post('/sifre-sifirla', 'AuthController@doResetPassword');
$router->get('/df-admin/2fa', 'AuthController@twofa');
$router->post('/df-admin/2fa/verify', 'AuthController@verifyTwofa');
$router->get('/df-admin/2fa/setup', 'AuthController@setup2fa');
$router->post('/df-admin/2fa/enable', 'AuthController@enable2fa');
$router->post('/df-admin/2fa/disable', 'AuthController@disable2fa');

$app->run();