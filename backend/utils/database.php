<?php
declare(strict_types=1);

$host = '';
$port = '3306';
$dbname = '';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}
?>