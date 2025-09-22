<?php

function waitForMySQL($host, $port, $username, $password, $maxAttempts = 10) {
    $attempt = 0;
    
    while ($attempt < $maxAttempts) {
        try {
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password, [
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            echo "✅ MySQL доступен на $host:$port!\n";
            return $pdo;
        } catch (PDOException $e) {
            $attempt++;
            echo "⏳ Ожидание MySQL ($host:$port)... попытка $attempt/$maxAttempts\n";
            sleep(5);
        }
    }
    
    throw new Exception("Не удалось подключиться к MySQL на $host:$port после $maxAttempts попыток");
}

try {
    echo "=== Инициализация базы данных Task Manager ===\n\n";
    
    // Подключаемся к MySQL внутри Docker сети
    $pdo = waitForMySQL('mysql', 3306, 'root', 'rootpassword');
    
    echo "✅ Используем подключение: mysql:3306\n";
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ База данных 'task_manager' создана\n";
    
    $pdo->exec("USE task_manager");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tasks (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            status ENUM('не выполнена', 'выполнена') DEFAULT 'не выполнена',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Таблица 'tasks' создана\n";
    
    // Создаем пользователя (если не существует)
    $pdo->exec("CREATE USER IF NOT EXISTS 'app_user'@'%' IDENTIFIED BY 'app_password'");
    $pdo->exec("GRANT ALL PRIVILEGES ON task_manager.* TO 'app_user'@'%'");
    $pdo->exec("FLUSH PRIVILEGES");
    echo "✅ Пользователь 'app_user' создан\n";
    
    // Проверяем и добавляем тестовые данные
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tasks");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($count == 0) {
        $pdo->exec("
            INSERT INTO tasks (title, description, status) VALUES
            ('Изучить PHP', 'Освоить основы программирования на PHP', 'не выполнена'),
            ('Создать веб-приложение', 'Разработать Task Manager на PHP и MySQL', 'не выполнена'),
            ('Изучить Bootstrap', 'Освоить основы фреймворка Bootstrap', 'выполнена'),
            ('Настроить Docker', 'Запустить MySQL в Docker контейнере', 'не выполнена'),
            ('Изучить CRUD операции', 'Реализовать Create, Read, Update, Delete', 'выполнена')
        ");
        echo "✅ Тестовые данные добавлены (5 записей)\n";
    } else {
        echo "✅ В таблице уже есть $count записей\n";
    }
    
    // Проверяем подключение с app_user
    try {
        $appPdo = new PDO("mysql:host=mysql;port=3306;dbname=task_manager", 'app_user', 'app_password');
        echo "✅ Подключение с app_user успешно\n";
    } catch (Exception $e) {
        echo "⚠️ Не удалось подключиться с app_user: " . $e->getMessage() . "\n";
    }
    
    echo "\n🎉 База данных полностью инициализирована!\n";
    
} catch (Exception $e) {
    echo "\n❌ Критическая ошибка: " . $e->getMessage() . "\n";
    exit(1);
}