<?php
declare(strict_types=1);

$host="localhost";
$port = "3306";
$dbname = "ariadne_classroom";
$username = "root";
$password = "azerty";

$db = null;
try {
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}
