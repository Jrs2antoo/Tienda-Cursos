<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use Jrs2a\TiendaCursos\Core\Database;

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri('http://localhost/tiendaCursos/callback.php');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // Verificar que no hay error en el token
    if (isset($token['error'])) {
        die('Error de autenticación: ' . htmlspecialchars($token['error_description'] ?? $token['error']));
    }

    $client->setAccessToken($token);

    $oauth      = new Google_Service_Oauth2($client);
    $googleUser = $oauth->userinfo->get();

    $email    = $googleUser->email;
    $fullName = $googleUser->name;

    $db   = Database::connect();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $insert = $db->prepare("
            INSERT INTO users (full_name, email, password, confirmado)
            VALUES (:full_name, :email, '', 1)
        ");
        $insert->bindValue(':full_name', $fullName, PDO::PARAM_STR);
        $insert->bindValue(':email', $email, PDO::PARAM_STR);
        $insert->execute();
        $userId = $db->lastInsertId();
        $role   = 'user';
    } else {
        $userId = $user['id'];
        $role   = $user['role'];
    }

    // Sin segundo session_start() — ya está arriba
    session_regenerate_id(true);
    $_SESSION['user_id']   = $userId;
    $_SESSION['email']     = $email;
    $_SESSION['full_name'] = $fullName;
    $_SESSION['role']      = $role;

    header('Location: /tiendaCursos/');
    exit();
}
