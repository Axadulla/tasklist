<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    die("⛔ Вы не авторизованы!");
}

$id = intval($_GET['id']);

$sql = $conn->prepare("SELECT * FROM tasks WHERE id=? and user_id=?");
$sql->bind_param("ii", $id, $_SESSION["user_id"]);
$sql->execute();
$task = $sql->get_result()->fetch_assoc();



if (!$task){
    die("⛔Нет доступа!");
}else{
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = $conn->prepare("UPDATE tasks SET title=?,description=?,status=? WHERE id=? and user_id=?");
        $sql->bind_param("ssiii", $title, $description, $status, $id,$_SESSION["user_id"]);
        $sql->execute();

        header("Location: index.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать задачу</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'header.php'; ?>
<div class="container">

    <h1>Редактировать задачу</h1>
    <form method="POST">
        <p>Название: <input type="text" name="title" value="<?= $task['title'] ?>" required></p>
        <p>Описание: <textarea name="description"><?= $task['description'] ?></textarea></p>
        <p><label><input type="checkbox" name="status" <?= $task['status'] ? "checked" : "" ?> > Выполнено</label></p>
        <button type="submit">Сохранить</button>
    </form>
    <a href="index.php">⬅ Вернуться</a>

</div>
</body>
</html>
