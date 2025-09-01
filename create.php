<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    echo "⛔ Вы не авторизованы!";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $user_id = $_SESSION["user_id"];

    $sql = $conn->prepare("INSERT INTO `tasks` (title, description, user_id) VALUES (?, ?, ?)");
    $sql->bind_param("ssi", $title, $description, $user_id);
    $sql->execute();

    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <h1>Добавить задачу</h1>
    <form method="POST">
        <p>Название: <input type="text" name="title" required></p>
        <p>Описание: <textarea name="description"></textarea></p>
        <button type="submit">Сохранить</button>
    </form>
    <a href="index.php">⬅ Вернуться</a>

</div>
</body>
</html>
