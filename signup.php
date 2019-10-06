<?php
declare(strict_types=1);

if (isset($_COOKIE["CurrentUser"]) or isset($_SESSION['current_user'])) {
    header('Location: home');
}

require_once "backend/server.php";
require_once "frontend/signup.html";
?>