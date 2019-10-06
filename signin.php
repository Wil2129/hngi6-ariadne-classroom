<?php
declare(strict_types=1);

if (isset($_COOKIE["CurrentUser"]) or isset($_SESSION['current_user'])) {
    header('Location: home.php');
}

require_once "backend/server.php";
require_once "frontend/signin.html";
?>