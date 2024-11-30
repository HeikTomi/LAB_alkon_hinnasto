<?php
// This is meant to be used outside of app, just run:
// php [filename] in terminal to create database table and rows based on CSV-file
require_once __DIR__ . '/../config/config.php';

$columns2Include = [
    "Numero",
    "Nimi",
    "Valmistaja",
    "Pullokoko",
    "Hinta",
    "Litrahinta",
    "Tyyppi",
    "Valmistusmaa",
    "Vuosikerta", // Vintage
    "Alkoholi-%", // Alcohol %
    "\"Energia kcal/100 ml\"" // Energy kcal/100 ml
];

$csvFile = __DIR__ . '/../temp/hinnasto.csv';

function connectToDatabase() {
    $host = $_ENV['DB_HOST'];
    $dbname =  $_ENV['DB_NAME'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

function createTable($pdo) {
    // Drop the old table if it exists
    $pdo->exec("DROP TABLE IF EXISTS alko_products");

    // Create the new table
    $sql = "CREATE TABLE alko_products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            Number VARCHAR(50),                       -- Numero
            Name VARCHAR(255),                        -- Nimi
            Manufacturer VARCHAR(255),                -- Valmistaja
            BottleSize VARCHAR(50),                   -- Pullokoko
            Price DECIMAL(10, 2),                     -- Hinta
            LiterPrice DECIMAL(10, 2),                -- Litrahinta
            Type VARCHAR(100),                        -- Tyyppi
            CountryOfManufacture VARCHAR(100),        -- Valmistusmaa
            Vintage INT,                              -- Vuosikerta
            AlcoholPercentage DECIMAL(5,2),           -- Alkoholiprosentti
            Energy DECIMAL(10,2)                      -- Energia kcal/100 ml
        )";
        
        $pdo->exec($sql);
}

function insertData($pdo, $data) {
    // Convert empty strings to NULL for numeric fields
    $data[5] = ($data[5] === '') ? null : $data[5]; // Litrahinta
    $data[4] = ($data[4] === '') ? null : $data[4]; // Hinta
    $data[8] = ($data[8] === '') ? null : $data[8]; // Vuosikerta (Vintage)
    $data[9] = ($data[9] === '') ? null : $data[9]; // Alkoholiprosentti (Alcohol %)
    $data[10] = ($data[10] === '') ? null : $data[10]; // Energia (Energy kcal/100 ml)

    $sql = "INSERT INTO alko_products (Number, Name, Manufacturer, BottleSize, Price, LiterPrice, Type, CountryOfManufacture, Vintage, AlcoholPercentage, Energy) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

try {
    $pdo = connectToDatabase();
    
    createTable($pdo);

    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        // Skip the header row
        fgetcsv($handle, 1000, ",");

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Adjust the indices based on your CSV structure according to columns2Include
            $rowData = [
                $data[0],  // Numero (Index 0)
                $data[1],  // Nimi (Index 1)
                $data[2],  // Valmistaja (Index 2)
                $data[3],  // Pullokoko (Index 3)
                (float)$data[4],  // Hinta (Price) (Index 4)
                (float)$data[5],  // Litrahinta (Liter Price) (Index 5)
                $data[8],  // Tyyppi (Type) (Index 8)
                $data[12], // Valmistusmaa (Country of Manufacture) (Index 12)
                (int)$data[14], // Vuosikerta (Vintage) (Index 14)
                (float)$data[21], // Alkoholiprosentti (Alcohol %) (Index 21)
                (float)$data[26]  // Energia kcal/100 ml (Energy) (Index 26)
            ];
            insertData($pdo, $rowData);
        }
        fclose($handle);
    }

    echo "Data imported successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}