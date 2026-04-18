<?php

// Database configuration
$host = 'localhost';
$dbname = 'blogs';
$username = 'root';
$password = '1234';
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// PDO options for error handling and fetching
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);
    

    $limit = $_GET['limit'] ?? 10;
    $offset = $_GET['offset'] ?? 0;

    $dep_id = 0;
    if (isset($_GET['dep_id'])) {
        $dep_id = $_GET['dep_id'];
        // Example: Prepared statement query
        $stmt = $pdo->prepare("SELECT * FROM blogs where dep_id = $dep_id limit $offset, $limit");
    } else {
        // Example: Prepared statement query
        $stmt = $pdo->prepare("SELECT * FROM blogs limit $offset, $limit");
    }
    $stmt->execute();
    $blogs = $stmt->fetchAll();
    
    // Example: Prepared statement query
    $stmt = $pdo->prepare("SELECT * FROM department");
    $stmt->execute();
    $departments = $stmt->fetchAll();


    // print_r($blogs);

    
} catch (PDOException $e) {
    // Handle connection errors securely (don't expose details in production)
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}

?>