<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die('Доступ запрещён. <a href="login.php">Войти как admin</a>');
}
require_once 'db_config.php';

$users = $conn->query("SELECT id, username, email, role, created_at FROM users ORDER BY id");

// Онлайн из visitors.txt
$online = 0;
if (file_exists('visitors.txt')) {
    $now = time();
    $lines = file('visitors.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', $line);
        if (isset($parts[1]) && ($now - (int)$parts[1]) < 30) {
            $online++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><title>Админ-панель</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>👑 Панель администратора</h1><nav><ul><li><a href="index.php">Главная</a></li><li><a href="logout.php">Выйти</a></li></ul></nav></header>
<main>
    <h2>Статистика посещений</h2>
    <p>🔴 Онлайн сейчас: <strong><?=$online?></strong></p>
    <p>📊 Счётчики Yandex Metrika и Google Analytics установлены.</p>
    
    <h2>📋 Список всех пользователей</h2>
    <table border="1" cellpadding="8" style="width:100%; background:#222; color:#fff; border-collapse:collapse;">
        <tr style="background:#444;"><th>ID</th><th>Логин</th><th>Email</th><th>Роль</th><th>Дата регистрации</th></tr>
        <?php while($row = $users->fetch_assoc()): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=htmlspecialchars($row['username'])?></td>
            <td><?=htmlspecialchars($row['email'])?></td>
            <td><?=$row['role']?></td>
            <td><?=$row['created_at']?></td>
        </tr>
        <?php endwhile; ?>
    095
</main>
</body>
</html>