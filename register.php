<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];

    if ($password !== $password_confirm) {
        $error = "Пароли не совпадают!";
    } else {
        $sql = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $error = "Пользователь с таким логином уже существует!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $sql->bind_param("ss", $username, $hashedPassword);

            if ($sql->execute()) {
                $_SESSION["user_id"] = $conn->insert_id;
                $_SESSION["username"] = $username;

                header("Location: index.php");
                exit;
            } else {
                $error = "Ошибка при регистрации!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="form-container">
    <h1>Регистрация</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="password" name="password_confirm" placeholder="Повторите пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</div>
</body>
</html>
