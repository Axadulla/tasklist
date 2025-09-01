<?php
session_start();
include 'db.php';



$result = $conn->query("SELECT * FROM tasks");

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Task List</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php include 'header.php'; ?>
<div class="container">

    <h1>Список задач</h1>
    <a href="create.php">➕ Добавить задачу</a>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['status'] ? "✅ Задача Выполнено" : "⏳ В процессе" ?></td>
                <td>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']): ?>
                        <a href="edit.php?id=<?= $row['id'] ?>">Редактировать</a> |
                        <a href="delete.php?id=<?= $row['id'] ?>">Удалить</a>
                    <?php else: ?>
                        👀 Не ваша задача
                    <?php endif; ?>
                </td>
            </tr>
        <?php  endwhile;  ?>
    </table>

</div>

</body>
</html>
