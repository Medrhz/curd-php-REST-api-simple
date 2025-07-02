<?php
$host = 'localhost';
$dbname = 'test_api';
$user = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]));
}
