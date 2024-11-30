<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the user's home directory
$homeDir = "/home/x018489/";

require_once "{$homeDir}public_html/alko/vendor/autoload.php";
use Dotenv\Dotenv;

// Load environment variables and check that they are valid
try {
    // Create an immutable Dotenv instance
    $dotenv = Dotenv::createImmutable($homeDir);

    // Load the environment variables from the .env file
    $dotenv->load();

    // Require specific environment variables to ensure they are loaded
    $dotenv->required(['DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_NAME']);
    
    // Optionally check if they are not empty
    $dotenv->required(['DB_HOST', 'DB_USER', 'DB_PASSWORD', 'DB_NAME'])->notEmpty();

} catch (Exception $e) {
    // Handle the error (e.g., log it or display a message)
    echo "Error loading environment variables: " . $e->getMessage();
}