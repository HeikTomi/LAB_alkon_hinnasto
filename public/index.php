<?php
require_once __DIR__ . '/../app/Controllers/hinnasto_controller.php';

// Get the current page number from query parameters, defaulting to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$controller = new AlkonHinnastoController();

// Call the index method of the controller, which returns data including products, types, and countries for filter lists
$data = $controller->index($page);

// Check if keys exist in the data array before accessing them
$products = $data['products'] ?? [];
$totalPages = $data['totalPages'] ?? 0;
$currentPage = $data['currentPage'] ?? 1;
$types = $data['types'] ?? [];
$countries = $data['countries'] ?? [];

// Create a new instance of the view and render it with the data
$view = new AlkonHinnastoView();
echo $view->render($products, $totalPages, $currentPage, $types, $countries);