<?php
session_start();
require_once 'db.php';

$loginMessage = '';

if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        session_regenerate_id();
        header("Cache-Control: no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Location: home.php");
        exit();
    } else {
        $loginMessage = "Błędna nazwa użytkownika lub hasło.";
    }
}
?>

