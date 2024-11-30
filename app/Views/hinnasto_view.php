<?php
class AlkonHinnastoView {
    public function render($data, $totalPages, $currentPage, $types, $countries) {
        $products = $data;
        $type = $_GET['type'] ?? '';
        $country = $_GET['country'] ?? '';
        $bottleSizeMin = $_GET['bottleSizeMin'] ?? '0';
        $bottleSizeMax = $_GET['bottleSizeMax'] ?? '1';
        $priceMin = $_GET['priceMin'] ?? '0';
        $priceMax = $_GET['priceMax'] ?? '1000';
        $energyMin = $_GET['energyMin'] ?? '0';
        $energyMax = $_GET['energyMax'] ?? '50';

        // Start generating HTML
        $htmlHeaders = '<!DOCTYPE html>
        <html lang="fi">
        <head>
            <meta charset="UTF-8">
            <title>Alko Product Catalog</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" type="text/css" href="./css/styles.css">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT+4+g7qD+2A5nL5g5l5Z5z5y5G5z5Z5Z5g5Z5Z5g5Z5g5Z" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-JjSmVgyd0p3p8d0p3p8d0p3p8d0p3p8d0p3p8d0p3p8d0p3p8d0p3p8d0p3" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></script>
        </head>';

        $html = $htmlHeaders;
        
        $html .= '
            <body>
            <div class="container">
                <h1>Alko Product Catalog 29.11.2024</h1>
            </div>

            <div class="filter-section container">';

        $formHtml = '<form method="GET" action="" class="mb-4">
            <div class="mb-3">
                <label for="type" class="form-label">Type:</label>
                <select id="type" name="type" class="form-select">
                    <option value="">All</option>';
                   foreach ($types as $typeOption) {
                   
                        $selected = ($type == $typeOption) ? 'selected' : '';
                        $formHtml .= '<option value="'.htmlspecialchars($typeOption).'" '.$selected.' >'.htmlspecialchars($typeOption) .'</option>';
                    }
                $formHtml .= '</select>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country of Manufacture:</label>
                <select id="country" name="country" class="form-select">
                    <option value="">All</option>';
                    foreach ($countries as $countryOption){
                        $selected = ($country == $countryOption) ? 'selected' : '';
                        if ($countryOption != ""){
                            $formHtml .= '<option value="'.htmlspecialchars($countryOption).'" '.$selected.'>'.htmlspecialchars($countryOption) .'</option>';
                        }
                    };
                    unset($selected);
                $formHtml .= '</select>
            </div>

            <div class="mb-3">
                <label for="bottleSize">Bottle Size:</label>
                <div class="slider-container">
                    <input type="range" id="bottleSizeMin" class="slider form-range" name="bottleSizeMin" min="0" max="1" step="0.1" value="' . htmlspecialchars($bottleSizeMin) . '">
                    <input type="range" id="bottleSizeMax" class="slider form-range" name="bottleSizeMax" min="0" max="1" step="0.1" value="' . htmlspecialchars($bottleSizeMax) . '">
                </div>
                <p>Selected Bottle Size: <span id="bottleSizeDisplayMin">' . htmlspecialchars($bottleSizeMin) . '</span> - <span id="bottleSizeDisplayMax">' . htmlspecialchars($bottleSizeMax) . ' l</span></p>
            </div>

            <div class="mb-3">
                <label for="price">Price Range:</label>
                <div class="slider-container">
                    <input type="range" id="priceMin" class="slider form-range" name="priceMin" min="0" max="1000" step="0.01" value="' . htmlspecialchars($priceMin) . '">
                    <input type="range" id="priceMax" class="slider form-range" name="priceMax" min="0" max="1000" step="0.01" value="' . htmlspecialchars($priceMax) . '">
                </div>
                <p>Selected Price: <span id="priceDisplayMin">' . htmlspecialchars($priceMin) . '</span> - <span id="priceDisplayMax">' . htmlspecialchars($priceMax) . ' €</span></p>
            </div>

            <div class="mb-3">
                <label for="energy">Energy Range:</label>
                <div class="slider-container">
                    <input type="range" id="energyMin" class="slider form-range" name="energyMin" min="0" max="50" step="0.1" value="' . htmlspecialchars($energyMin) . '">
                    <input type="range" id="energyMax" class="slider form-range" name="energyMax" min="0" max="50" step="0.1" value="' . htmlspecialchars($energyMax) . '">
                </div>
                <p>Selected Energy: <span id="energyDisplayMin">' . htmlspecialchars($energyMin) . '</span> - <span id="energyDisplayMax">' . htmlspecialchars($energyMax) . ' kcal/100 ml</span></p>
            </div>

            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </form>';

        $html .= $formHtml;


        $html .= '
            </div><div class="container">

            <table>
                <tr>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Manufacturer</th>
                    <th>Bottle Size</th>
                    <th>Price</th>
                    <th>Liter Price</th>
                    <th>Type</th>
                    <th>Country of Manufacture</th>
                    <th>Vintage</th>
                    <th>Alcohol %</th>
                    <th>Energy kcal/100 ml</th>
                </tr>';

        foreach ($products as $product) {
            $html .= '<tr>
                <td>' . htmlspecialchars($product['Number'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Name'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Manufacturer'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['BottleSize'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Price'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['LiterPrice'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Type'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['CountryOfManufacture'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Vintage'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['AlcoholPercentage'] ?? '') . '</td>
                <td>' . htmlspecialchars($product['Energy'] ?? '') . '</td>
            </tr>';
        }

        // Pagination Links
        $html .= '<div class="pagination">';
        if ($currentPage > 1) {
            $html .= '<a class="btn btn-primary" style="margin-left:0;" href="?page=' . ($currentPage - 1) .
                     '&type=' . urlencode($type) .
                     '&country=' . urlencode($country) .
                     '&bottleSizeMin=' . urlencode($bottleSizeMin) .
                     '&bottleSizeMax=' . urlencode($bottleSizeMax) .
                     '&priceMin=' . urlencode($priceMin) .
                     '&priceMax=' . urlencode($priceMax) .
                     '&energyMin=' . urlencode($energyMin) .
                     '&energyMax=' . urlencode($energyMax) .
                     '">Previous</a>';
        }
        $html .= '<b style="line-height:2em;">'.$currentPage." of ".$totalPages."</b>";
        if ($currentPage < $totalPages) {
            $html .= '<a class="btn btn-primary" href="?page=' . ($currentPage + 1) .
                     '&type=' . urlencode($type) .
                     '&country=' . urlencode($country) .
                     '&bottleSizeMin=' . urlencode($bottleSizeMin) .
                     '&bottleSizeMax=' . urlencode($bottleSizeMax) .
                     '&priceMin=' . urlencode($priceMin) .
                     '&priceMax=' . urlencode($priceMax) .
                     '&energyMin=' . urlencode($energyMin) .
                     '&energyMax=' . urlencode($energyMax) .
                     '">Next</a>';
        }
        $html .= '</div>';

        // Close HTML tags
        $html .= '</table></div></body>';

        // Link to the external JavaScript file
        $html .= '<script src="./js/rangeSlider.js"></script>';
        
        return $html .= '</html>';
    }
}