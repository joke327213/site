<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['password_hash'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><title>Вход</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>Авторизация</h1><nav><ul><li><a href="index.php">Главная</a></li><li><a href="register.php">Регистрация</a></li></ul></nav></header>
<main>
    <?php if($error): ?>
        <p style="color:red; background:#300; padding:10px; border-radius:10px;"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>
    <form method="post" style="background:#222; padding:20px; border-radius:20px;">
        <input type="text" name="username" placeholder="Логин" required style="width:100%; padding:8px; margin:5px 0;"><br>
        <input type="password" name="password" placeholder="Пароль" required style="width:100%; padding:8px; margin:5px 0;"><br>
        <button type="submit" style="margin-top:10px; background:#333; color:#fff; padding:10px 20px; border:none; border-radius:10px;">Войти</button>
    </form>
</main>
</body>
</html>