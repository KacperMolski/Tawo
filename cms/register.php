<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Użytkownik o podanej nazwie już istnieje.";
    } else {
        $insertStmt = $db->prepare("INSERT INTO users (username, password, created_at) VALUES (:username, :password, NOW())");
        $insertStmt->bindParam(':username', $username);
        $insertStmt->bindParam(':password', $password);

        if ($insertStmt->execute()) {
            $_SESSION['user_id'] = $db->lastInsertId();
            session_regenerate_id();
            header("Cache-Control: no-store, must-revalidate");
            header("Pragma: no-cache");
            header("Location: home.php");
            exit();
        } else {
            echo "Wystąpił błąd podczas rejestracji.";
        }
    }
}
?>  
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styl.css">
    <link rel="stylesheet" href="../media-1024.css">
    <link rel="stylesheet" href="../media-768.css">
    <link rel="shortcut icon" href="../img/icons/favicon.jpg" type="image/x-icon">
    <title>Document</title>
</head>

<body>
    <div class="row">
    <div class="container">
        <div class="logo-cms">
            <img src="../img/icons/logo.png" alt="Logo">
        </div>
        <?php
        if (isset($_SESSION['user_id'])) {
            header("Location: home.php");
            exit();
        }
        ?>
        <div class="login-form">
            <h2>Zarejestruj</h2>
            <form action="register.php" method="POST">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Zaloguj</button>
            </form>
        </div>
        <div class="switch-form">
            Nie masz konta? <a href="index.php">Zaloguj się</a>
        </div>
    </div>
    </div>
</body>

</html>