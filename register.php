<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db_config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $email, $hash);
        
        if ($stmt->execute()) {
            $success = "Регистрация успешна! Теперь <a href='login.php'>войдите</a>.";
        } else {
            if ($conn->errno == 1062) {
                $error = "Пользователь или email уже существуют.";
            } else {
                $error = "Ошибка: " . $conn->error;
            }
        }
        $stmt->close();
    } else {
        $error = "Заполните все поля.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><title>Регистрация</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>Регистрация</h1><nav><ul><li><a href="index.php">Главная</a></li><li><a href="login.php">Вход</a></li></ul></nav></header>
<main>
    <?php if($error): ?>
        <p style="color:red; background:#300; padding:10px; border-radius:10px;"><?=htmlspecialchars($error)?></p>
    <?php endif; ?>
    <?php if($success): ?>
        <p style="color:green; background:#030; padding:10px; border-radius:10px;"><?=$success?></p>
    <?php endif; ?>
    <form method="post" style="background:#222; padding:20px; border-radius:20px;">
        <input type="text" name="username" placeholder="Логин" required style="width:100%; padding:8px; margin:5px 0;"><br>
        <input type="email" name="email" placeholder="Email" required style="width:100%; padding:8px; margin:5px 0;"><br>
        <input type="password" name="password" placeholder="Пароль" required style="width:100%; padding:8px; margin:5px 0;"><br>
        <button type="submit" style="margin-top:10px; background:#333; color:#fff; padding:10px 20px; border:none; border-radius:10px;">Зарегистрироваться</button>
    </form>
</main>
</body>
</html>