<?php
require_once __DIR__ . '/../core/Application.php';

use Core\Application;
$app = Application::getInstance();

$menuModel = new \App\Models\Menu();
$items = $menuModel->getItems(1);

echo "<pre>";
echo "getItems sonucu:\n";
print_r($items);
echo "</pre>";