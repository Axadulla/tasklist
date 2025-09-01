<?php
include "db.php";

?>
<header class="header">
    <div class="header-container">
        <h2 class="logo"><a href="index.php">Task Manager</a></h2>
        <nav class="nav">
            <?php if (isset($_SESSION["user_id"])): ?>
                <span class="username">👤 <?= htmlspecialchars($_SESSION["username"]) ?></span>
                <a href="profile.php?id=<?= $_SESSION['user_id'] ?>">Личный кабинет</a>
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="register.php">Регистрация</a>
                <a href="login.php">Войти</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

