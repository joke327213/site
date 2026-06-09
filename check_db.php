<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_config.php';

if ($conn->ping()) {
    echo "✅ Подключение к БД успешно!<br>";
    
    $result = $conn->query("SELECT COUNT(*) as cnt FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "✅ Таблица users существует. Пользователей: " . $row['cnt'];
    } else {
        echo "❌ Таблица users не найдена. Ошибка: " . $conn->error;
    }
} else {
    echo "❌ Нет подключения к БД: " . $conn->connect_error;
}
?>