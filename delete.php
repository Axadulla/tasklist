<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    die("⛔ Вы не авторизованы!");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM tasks WHERE id=? and user_id=?");
$stmt->bind_param("ii", $id, $_SESSION["user_id"]);
$stmt->execute();

header("Location: index.php");
exit;
