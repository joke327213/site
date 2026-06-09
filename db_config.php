<?php
$db_host = 'localhost';
$db_user = 'cryptoscam';
$db_pass = 'Xs87936!';
$db_name = 'cryptoscam';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die('Ошибка подключения: ' . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Создаём таблицу если нет
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Создаём админа если нет
$admin_check = $conn->query("SELECT id FROM users WHERE username='admin'");
if (!$admin_check || $admin_check->num_rows == 0) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, email, password_hash, role) 
                  VALUES ('admin', 'admin@cryptoscam.ru', '$hash', 'admin')");
    echo "Админ создан<br>";
}
?>