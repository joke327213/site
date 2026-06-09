<?php
session_start();
// Получаем роль пользователя (если авторизован)
$user_role = $_SESSION['role'] ?? 'guest';
$username = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <header>
        <h1>КриптоМошенничества</h1>
        <nav>
            <ul>
                <li><a href="index.php">🏠 Главная</a></li>
                <li><a href="types.php">📚 Категории</a></li>
                <li><a href="famous.php">⭐ Известные случаи</a></li>
                
                <?php if ($user_role === 'guest'): ?>
                    <!-- Гость: показывает кнопки входа и регистрации -->
                    <li><a href="login.php">🔐 Вход</a></li>
                    <li><a href="register.php">📝 Регистрация</a></li>
                <?php else: ?>
                    <!-- Авторизованный пользователь -->
                    <li style="color: #0f0; margin: 0 10px;">👋 Привет, <?= htmlspecialchars($username) ?></li>
                    
                    <?php if ($user_role === 'admin'): ?>
                        <!-- Администратор (группа A) -->
                        <li><a href="admin_users.php">👑 Админ-панель</a></li>
                        <li><a href="editor_submit.php">✏️ Редактору</a></li>
                    <?php elseif ($user_role === 'editor'): ?>
                        <!-- Редактор (группа B) -->
                        <li><a href="editor_submit.php">✏️ Отправить материал</a></li>
                    <?php endif; ?>
                    
                    <li><a href="logout.php">🚪 Выход</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>