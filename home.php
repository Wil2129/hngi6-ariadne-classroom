<?php
declare(strict_types=1);

if (! isset($_COOKIE["CurrentUser"]) and ! isset($_SESSION['current_user'])) {
    header('Location: signin');
}

require_once "backend/server.php";
require_once "frontend/home.html";
?>