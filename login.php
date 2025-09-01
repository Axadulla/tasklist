<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
<div class="form-container">
    <h1>Вход</h1>
    <?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Логин" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <button type="submit">Войти</button>
    </form>
    <p><a href="register.php">Нет аккаунта? Зарегистрироваться</a></p>
</div>
</body>
</html>
