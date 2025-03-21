<?php

// Database configuration using environment variables
$db_host = getenv('DATABASE_HOST');
$db_name = getenv('DATABASE_NAME');
$db_user = getenv('DATABASE_USER');
$db_pass = getenv('DATABASE_PASSWORD');
$db_charset = 'utf8mb4'; // Optional: specify the character set

// Data Source Name (DSN) for MySQL with PDO
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";

// PDO options for error handling
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    echo "Connected successfully to the database.";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
