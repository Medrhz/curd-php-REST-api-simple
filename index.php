<?php
require 'db.php';
require 'functions.php';

$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$route = $uri[2] ?? null; // users
$id = $uri[3] ?? null;    // id

if ($route === 'users') {
    require 'routes/users.php';
} else {
    sendResponse(["error" => "Route non trouvée"], 404);
}