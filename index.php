<?php
header("Access-Control-Allow-Origin: *");
// Pour autoriser les méthodes HTTP
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// Pour autoriser les en-têtes personnalisés (comme Content-Type)
header("Access-Control-Allow-Headers: Content-Type");
// === Gérer la requête OPTIONS ===
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
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
