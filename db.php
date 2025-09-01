<?php

$host = "sql208.infinityfree.com";
$user = "if0_39816394";
$pass = "BBTTJKGULxQ2yf4";
$db = "if0_39816394_my_db";

$conn = new mysqli($host, $user, $pass, $db);

$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

