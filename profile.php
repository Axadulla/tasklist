<?php
session_start();
include "db.php";

$id = intval($_GET['id']);

$sql = $conn->prepare("SELECT id, username, created_at FROM users WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

$sql2 = $conn->prepare("SELECT * FROM tasks WHERE user_id=?");
$sql2->bind_param("i", $id);
$sql2->execute();
$result2 = $sql2->get_result();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="profile-container">
    <h1>Профиль: <?= htmlspecialchars($row['username']) ?></h1>
    <div class="profile-info">
        <p><strong>ID:</strong> <?= $row['id'] ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($row['username']) ?></p>
        <p><strong>Дата регистрации:</strong> <?= $row['created_at'] ?></p>
    </div>
    <div class="profile-actions">
        <a href="index.php">⬅ Назад к задачам</a>
    </div>
</div>
<div class="container">

    <h1>Список задач пользователя <?= $row['username'] ?></h1>
    <?php if ($_SESSION['user_id'] == $id): ?>
        <a href="create.php">➕ Добавить задачу</a>
    <?php endif; ?>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        <?php while ($row2 = $result2->fetch_assoc()): ?>
            <tr>
                <td><?= $row2['id'] ?></td>
                <td><?= $row2['title'] ?></td>
                <td><?= $row2['description'] ?></td>
                <td><?= $row2['status'] ? "✅ Задача Выполнено" : "⏳ В процессе" ?></td>
                <td>
                    <?php if ($_SESSION['user_id'] == $row['id']): ?>
                        <a href="edit.php?id=<?= $row2['id'] ?>">Редактировать</a> |
                        <a href="delete.php?id=<?= $row2['id'] ?>">Удалить</a>
                    <?php else: ?>
                        🔒 Не доступа
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</div>


</body>
</html>
