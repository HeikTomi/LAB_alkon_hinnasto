<?php
require_once __DIR__ ."/../Models/hinnasto_model.php";
require_once __DIR__ ."/../Views/hinnasto_view.php";

class AlkonHinnastoController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new AlkonHinnastoModel();
        $this->view = new AlkonHinnastoView();
    }

    public function index($page = 1) {
        $limit = 25; // Number of rows per page

        // Calculate offset for pagination
        $offset = ($page - 1) * $limit;

         // Prepare filters based on GET parameters
         $filters = [
            'type' => $_GET['type'] ?? null,
            'country' => $_GET['country'] ?? null,
            'bottleSizeMin' => $_GET['bottleSizeMin'] ?? null,
            'bottleSizeMax' => $_GET['bottleSizeMax'] ?? null,
            'priceMin' => $_GET['priceMin'] ?? null,
            'priceMax' => $_GET['priceMax'] ?? null,
            'energyMin' => $_GET['energyMin'] ?? null,
            'energyMax' => $_GET['energyMax'] ?? null,
        ];

        // Fetch products for the current page with filters
        $products = $this->model->getProducts($limit, $offset, $filters);

        $totalProducts = $this->model->getTotalProducts($filters);
        $totalPages = ceil($totalProducts / $limit);

        // Ensure page number is within valid range
        if ($page < 1) {
            $page = 1;
        } elseif ($page > $totalPages) {
            $page = $totalPages;
        }

        // Fetch types and countries from the model
        $types = $this->model->getAllTypes(); 
        $countries = $this->model->getAllCountries(); 

        // Prepare data for the view
        return [
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'types' => $types,
            'countries' => $countries,
        ];
    }
}