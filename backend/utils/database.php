<?php
declare(strict_types=1);

$host="db4free.net";
$port = "3306";
$dbname = "ariadne";
$username = "ariadne";
$password = "azerty123";

$db = null;
try {
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password, array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
} catch (PDOException $e) {
    echo 'Database connection failed: ' . $e->getMessage();
}
