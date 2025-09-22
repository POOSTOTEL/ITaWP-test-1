<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT 1");
    echo "Соединение c MySQL установлено успешно!<br>";
    
    $stmt = $pdo->query("SHOW TABLES LIKE 'tasks'");
    if ($stmt->rowCount() > 0) {
        echo "Таблица 'tasks' существует!<br>";
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM tasks");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "В таблице $count записей<br>";
    } else {
        echo "Таблица 'tasks' не найдена<br>";
    }
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage() . "<br>";
}
?>