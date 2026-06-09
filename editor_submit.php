<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['editor', 'admin'])) {
    die('Доступ только для редакторов. <a href="login.php">Войти</a>');
}

$message_sent = false;
$mailto_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_SESSION['username'];
    
    $to = 'editor@cryptoscam.ru';
    $subject = "Новый материал от $author: $title";
    $body = "Автор: $author\n\nЗаголовок: $title\n\nТекст:\n$content";
    $mailto_link = "mailto:$to?subject=" . urlencode($subject) . "&body=" . urlencode($body);
    $message_sent = true;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><title>Отправить материал</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>✍️ Отправка материала редактору</h1><nav><ul><li><a href="index.php">Главная</a></li><li><a href="logout.php">Выйти</a></li></ul></nav></header>
<main>
    <?php if($message_sent): ?>
        <p style="color:green; background:#030; padding:10px; border-radius:10px;">✅ Материал готов к отправке.</p>
        <p><a href="<?=$mailto_link?>" style="display:inline-block; background:#333; color:#fff; padding:10px 20px; border-radius:10px; text-decoration:none;">📧 Отправить письмо редактору</a></p>
    <?php else: ?>
        <form method="post" style="background:#222; padding:20px; border-radius:20px;">
            <input type="text" name="title" placeholder="Заголовок материала" required style="width:100%; padding:8px; margin:5px 0;"><br>
            <textarea name="content" rows="10" placeholder="Текст новости / статьи ..." required style="width:100%; padding:8px; margin:5px 0;"></textarea><br>
            <button type="submit" style="margin-top:10px; background:#333; color:#fff; padding:10px 20px; border:none; border-radius:10px;">Подготовить письмо</button>
        </form>
    <?php endif; ?>
</main>
</body>
</html>