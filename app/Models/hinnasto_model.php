<?php
require_once __DIR__ . '/../../config/config.php';
class AlkonHinnastoModel {
    private $pdo;

    public function __construct() {
        $this->connectToDatabase();
    }

    private function connectToDatabase() {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getProducts($limit, $offset, $filters = []) {
        // Start building the SQL query
        $sql = "SELECT * FROM alko_products WHERE 1=1"; // 1=1 is a trick to simplify appending conditions
        $params = [];
    
        // Check for filters and append to the SQL query
        if (!empty($filters['type'])) {
            $sql .= " AND Type = :type";
            $params[':type'] = $filters['type'];
        }
    
        if (!empty($filters['country'])) {
            $sql .= " AND CountryOfManufacture = :country";
            $params[':country'] = $filters['country'];
        }
    
        if (isset($filters['bottleSizeMin']) && isset($filters['bottleSizeMax'])) {
            $sql .= " AND BottleSize BETWEEN :bottleSizeMin AND :bottleSizeMax";
            $params[':bottleSizeMin'] = (float)$filters['bottleSizeMin'];
            $params[':bottleSizeMax'] = (float)$filters['bottleSizeMax'];
        } elseif (isset($filters['bottleSizeMin'])) {
            $sql .= " AND BottleSize >= :bottleSizeMin";
            $params[':bottleSizeMin'] = (float)$filters['bottleSizeMin'];
        } elseif (isset($filters['bottleSizeMax'])) {
            $sql .= " AND BottleSize <= :bottleSizeMax";
            $params[':bottleSizeMax'] = (float)$filters['bottleSizeMax'];
        }
    
        if (isset($filters['priceMin']) && isset($filters['priceMax'])) {
            $sql .= " AND Price BETWEEN :priceMin AND :priceMax";
            $params[':priceMin'] = (float)$filters['priceMin'];
            $params[':priceMax'] = (float)$filters['priceMax'];
        } elseif (isset($filters['priceMin'])) {
            $sql .= " AND Price >= :priceMin";
            $params[':priceMin'] = (float)$filters['priceMin'];
        } elseif (isset($filters['priceMax'])) {
            $sql .= " AND Price <= :priceMax";
            $params[':priceMax'] = (float)$filters['priceMax'];
        }
    
        if (isset($filters['energyMin']) && isset($filters['energyMax'])) {
            $sql .= " AND Energy BETWEEN :energyMin AND :energyMax";
            $params[':energyMin'] = (float)$filters['energyMin'];
            $params[':energyMax'] = (float)$filters['energyMax'];
        } elseif (isset($filters['energyMin'])) {
            $sql .= " AND Energy >= :energyMin";
            $params[':energyMin'] = (float)$filters['energyMin'];
        } elseif (isset($filters['energyMax'])) {
            $sql .= " AND Energy <= :energyMax";
            $params[':energyMax'] = (float)$filters['energyMax'];
        }
    
        // Add LIMIT and OFFSET
        $sql .= " LIMIT :limit OFFSET :offset";
    
        // Prepare and execute the statement
        $stmt = $this->pdo->prepare($sql);
    
        // Bind parameters
        foreach ($params as $key => &$value) {
            if (is_float($value)) {
                // Bind float values
                $stmt->bindParam($key, $value, PDO::PARAM_STR); // Use PDO::PARAM_STR for float binding
            } else {
                // Bind other types normally
                $stmt->bindParam($key, $value);
            }
        }
        
        // Bind limit and offset
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    
        // Execute the statement
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts($filters = []) {
        // Start building the SQL query for counting rows
        $sql = "SELECT COUNT(*) FROM alko_products WHERE 1=1"; 
        $params = [];
    
        // Check for filters and append to the SQL query
        if (!empty($filters['type'])) {
            $sql .= " AND Type = :type";
            $params[':type'] = $filters['type'];
        }
    
        if (!empty($filters['country'])) {
            $sql .= " AND CountryOfManufacture = :country";
            $params[':country'] = $filters['country'];
        }
    
        if (isset($filters['bottleSizeMin']) && isset($filters['bottleSizeMax'])) {
            $sql .= " AND BottleSize BETWEEN :bottleSizeMin AND :bottleSizeMax";
            $params[':bottleSizeMin'] = (float)$filters['bottleSizeMin'];
            $params[':bottleSizeMax'] = (float)$filters['bottleSizeMax'];
        } elseif (isset($filters['bottleSizeMin'])) {
            $sql .= " AND BottleSize >= :bottleSizeMin";
            $params[':bottleSizeMin'] = (float)$filters['bottleSizeMin'];
        } elseif (isset($filters['bottleSizeMax'])) {
            $sql .= " AND BottleSize <= :bottleSizeMax";
            $params[':bottleSizeMax'] = (float)$filters['bottleSizeMax'];
        }
    
        if (isset($filters['priceMin']) && isset($filters['priceMax'])) {
            $sql .= " AND Price BETWEEN :priceMin AND :priceMax";
            $params[':priceMin'] = (float)$filters['priceMin'];
            $params[':priceMax'] = (float)$filters['priceMax'];
        } elseif (isset($filters['priceMin'])) {
            $sql .= " AND Price >= :priceMin";
            $params[':priceMin'] = (float)$filters['priceMin'];
        } elseif (isset($filters['priceMax'])) {
            $sql .= " AND Price <= :priceMax";
            $params[':priceMax'] = (float)$filters['priceMax'];
        }
    
        if (isset($filters['energyMin']) && isset($filters['energyMax'])) {
            $sql .= " AND Energy BETWEEN :energyMin AND :energyMax";
            $params[':energyMin'] = (float)$filters['energyMin'];
            $params[':energyMax'] = (float)$filters['energyMax'];
        } elseif (isset($filters['energyMin'])) {
            $sql .= " AND Energy >= :energyMin";
            $params[':energyMin'] = (float)$filters['energyMin'];
        } elseif (isset($filters['energyMax'])) {
            $sql .= " AND Energy <= :energyMax";
            $params[':energyMax'] = (float)$filters['energyMax'];
        }
    
        // Prepare and execute count statement
        $stmt = $this->pdo->prepare($sql);
    
        // Bind parameters
        foreach ($params as $key => &$value) {
            // Bind all values normally
            $stmt->bindParam($key, $value);
        }
    
        // Execute the statement
        if (!$stmt->execute()) {
            // If execution fails, print error information
            print_r($stmt->errorInfo());
        }
    
        // Return the total count of products based on filters
        return (int)$stmt->fetchColumn(); // Fetches the first column of the first row
    }

    public function getAllTypes() {
        // Fetch all distinct types from the database
        $stmt = $this->pdo->query("SELECT DISTINCT Type FROM alko_products");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllCountries() {
        // Fetch all distinct countries from the database
        $stmt = $this->pdo->query("SELECT DISTINCT CountryOfManufacture FROM alko_products");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}