<?php
header('Content-Type: application/json');
$sessionId = $_COOKIE['visitor_session'] ?? session_id();
$now = time();

// Получаем текущую сессию посетителя
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Устанавливаем cookie для уникальности (1 час)
    setcookie('visitor_session', $sessionId, time() + 3600, '/');
    
    // Записываем только если нет свежей записи
    $lines = file_exists('visitors.txt') ? file('visitors.txt', FILE_IGNORE_NEW_LINES) : [];
    foreach ($lines as $line) {
        list($sid, $time) = explode('|', $line);
        if ($sid === $sessionId && ($now - $time < 30)) {
            exit; // Уже есть свежая запись
        }
    }
    
    file_put_contents('visitors.txt', $sessionId . '|' . $now . "\n", FILE_APPEND | LOCK_EX);
    exit;
}

// Считаем онлайн (последние 30 секунд) + очищаем старое
$visitors = [];
if (file_exists('visitors.txt')) {
    $lines = file('visitors.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($sid, $time) = explode('|', $line);
        if (($now - (int)$time) < 30) {
            $visitors[] = $line;
        }
    }
    file_put_contents('visitors.txt', implode("\n", $visitors) . "\n");
}

echo json_encode(['online' => count($visitors)]);
?>
