<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3;url=/">
    <title>404 - КриптоМошенничества</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header><h1>404</h1>
        <nav><ul>
            <li><a href="index.php">Главная</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Выйти</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
                <li><a href="register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul></nav>
    </header>
    <main><h2>Страница не найдена</h2><p>Перенаправление через 3 сек...</p></main>
    <script src="script.js"></script>
</body>
</html>