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
        session_start();
        if (isset($_SESSION['user_id'])) {
            header("Location: home.php");
            exit();
        }
        ?>
        <div class="login-form">
            <h2>Zaloguj się</h2>
            <?php if (!empty($loginMessage)) : ?>
                <p class="error-message"><?php echo $loginMessage; ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Zaloguj</button>
            </form>
            <div class="switch-form">
                Nie masz konta? <a href="register.php">Zarejestruj się</a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>