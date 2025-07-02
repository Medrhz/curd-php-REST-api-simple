<?php
$method = $_SERVER['REQUEST_METHOD']; // post get put delete
$id = $id ?? null;
echo "$id";
$input = json_decode(file_get_contents("php://input"), true);
// GET /index.php/users or /users
if ($method === 'GET') {
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            sendResponse($user);
        } else {
            sendResponse(["error" => "Utilisateur non trouvé"], 404);
        }
    } else {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        sendResponse($users);
    }
}

// POST
elseif ($method === 'POST') {
    if (!isset($input['name']) || !isset($input['email'])) {
        sendResponse(["error" => "Champs manquants"], 400);
    }
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute([$input['name'], $input['email']]);
    sendResponse(["message" => "Utilisateur ajouté"], 201);
}
// PUT
elseif ($method === 'PUT' && $id) {
    if (!isset($input['name']) || !isset($input['email'])) {
        sendResponse(["error" => "Champs manquants"], 400);
    }
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$input['name'], $input['email'], $id]);
    sendResponse(["message" => "Utilisateur modifié"]);
}
// DELETE
elseif ($method === 'DELETE' && $id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["id" => $id]);
    sendResponse(["message" => "Utilisateur supprimé"]);
} else {
    sendResponse(["error" => "Méthode non autorisée"], 405);
}