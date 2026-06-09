<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Полная диагностика MySQL</h2>";

// ЗАМЕНИТЕ ЭТИ ДАННЫЕ НА СВОИ (из phpMyAdmin)
$db_host = 'mysql.web-prj.ru';
$db_user = 'cryptoscam';        // Ваш логин
$db_pass = 'ВАШ_ПАРОЛЬ';        // Ваш пароль от БД (НЕ от FTP!)
$db_name = 'cryptoscam';        // Имя базы

echo "1. Проверяем расширения PHP:<br>";
echo "MySQLi: " . (extension_loaded('mysqli') ? "✅ установлено" : "❌ НЕТ") . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? "✅ установлено" : "❌ НЕТ") . "<br><br>";

echo "2. Пробуем подключиться к $db_host...<br>";

// Способ 1: MySQLi
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo "❌ MySQLi ошибка: " . $conn->connect_error . "<br>";
    echo "Код ошибки: " . $conn->connect_errno . "<br>";
} else {
    echo "✅ MySQLi подключился!<br>";
    $conn->close();
}

// Способ 2: localhost вместо mysql.web-prj.ru
echo "<br>3. Пробуем localhost вместо mysql.web-prj.ru...<br>";
$conn2 = @new mysqli('localhost', $db_user, $db_pass, $db_name);

if ($conn2->connect_error) {
    echo "❌ localhost ошибка: " . $conn2->connect_error . "<br>";
} else {
    echo "✅ localhost сработал! Используйте 'localhost' в db_config.php<br>";
    $conn2->close();
}

// Способ 3: 127.0.0.1
echo "<br>4. Пробуем 127.0.0.1...<br>";
$conn3 = @new mysqli('127.0.0.1', $db_user, $db_pass, $db_name);

if ($conn3->connect_error) {
    echo "❌ 127.0.0.1 ошибка: " . $conn3->connect_error . "<br>";
} else {
    echo "✅ 127.0.0.1 сработал!<br>";
    $conn3->close();
}

// Проверяем, видит ли PHP таблицу users через已有的连接
echo "<br>5. Проверка наличия таблицы users в БД $db_name...<br>";

// Пробуем подключиться тем способом, который сработал
$conn_final = @new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn_final->connect_error) {
    echo "❌ Не удалось подключиться ни к одному хосту. Проверьте логин и пароль!<br>";
    echo "<br><strong>Что делать:</strong><br>";
    echo "1. Зайдите в phpMyAdmin<br>";
    echo "2. Проверьте, точно ли логин = 'cryptoscam'<br>";
    echo "3. Смените пароль на простой (например '123') и пропишите его в test<br>";
} else {
    $result = $conn_final->query("SHOW TABLES LIKE 'users'");
    if ($result->num_rows > 0) {
        echo "✅ Таблица users существует!<br>";
        
        // Считаем пользователей
        $count = $conn_final->query("SELECT COUNT(*) as cnt FROM users");
        $row = $count->fetch_assoc();
        echo "📊 В таблице users записей: " . $row['cnt'] . "<br>";
    } else {
        echo "❌ Таблица users НЕ найдена!<br>";
        echo "Выполните в phpMyAdmin SQL-запрос из моего предыдущего сообщения.<br>";
    }
    $conn_final->close();
}

// Проверка пароля admin
echo "<br>6. Дополнительная информация:<br>";
echo "Текущая директория: " . __DIR__ . "<br>";
echo "Версия PHP: " . phpversion() . "<br>";
?>