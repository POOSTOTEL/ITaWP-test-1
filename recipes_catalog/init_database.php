<?php

function waitForMySQL($host, $port, $username, $password, $maxAttempts = 10) {
    $attempt = 0;
    
    while ($attempt < $maxAttempts) {
        try {
            $pdo = new PDO("mysql:host=$host;port=$port", $username, $password, [
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            echo "MySQL доступен на $host:$port!\n";
            return $pdo;
        } catch (PDOException $e) {
            $attempt++;
            echo "Ожидание MySQL ($host:$port)... попытка $attempt/$maxAttempts\n";
            sleep(5);
        }
    }
    
    throw new Exception("Не удалось подключиться к MySQL на $host:$port после $maxAttempts попыток");
}

try {
    echo "=== Инициализация базы данных Каталог рецептов ===\n\n";
    
    $pdo = waitForMySQL('mysql', 3306, 'root', 'rootpassword');
    echo "Используем подключение: mysql:3306\n";
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "База данных 'recipes_catalog' создана\n";
    
    $pdo->exec("USE recipes_catalog");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS recipes (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            ingredients TEXT,
            cooking_time INT,
            status ENUM('не выполнена', 'выполнена') DEFAULT 'не выполнена',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "Таблица 'recipes' создана\n";
    
    $pdo->exec("CREATE USER IF NOT EXISTS 'app_user'@'%' IDENTIFIED BY 'app_password'");
    $pdo->exec("GRANT ALL PRIVILEGES ON task_manager.* TO 'app_user'@'%'");
    $pdo->exec("FLUSH PRIVILEGES");
    echo "Пользователь 'app_user' создан\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM recipes");
    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    if ($count == 0) {
        $pdo->exec("
            INSERT INTO recipes (title, ingredients, cooking_time, status) VALUES
            ('Спагетти Карбонара', 'Спагетти, яйца, бекон, пармезан, сливки, чеснок', 25, 'выполнена'),
            ('Оливье', 'Картофель, морковь, яйца, колбаса, огурцы, горошек, майонез', 40, 'не выполнена'),
            ('Борщ', 'Свекла, капуста, картофель, морковь, мясо, сметана', 60, 'не выполнена'),
            ('Цезарь', 'Курица, салат, сухарики, пармезан, соус цезарь', 20, 'выполнена'),
            ('Блины', 'Мука, молоко, яйца, сахар, соль', 30, 'не выполнена')
        ");
        echo "Тестовые данные добавлены (5 рецептов)\n";
    } else {
        echo "В таблице уже есть $count записей\n";
    }
    
    try {
        $appPdo = new PDO("mysql:host=mysql;port=3306;dbname=task_manager", 'app_user', 'app_password');
        echo "Подключение с app_user успешно\n";
    } catch (Exception $e) {
        echo "Не удалось подключиться с app_user: " . $e->getMessage() . "\n";
    }
    
    echo "\nБаза данных полностью инициализирована!\n";
    
} catch (Exception $e) {
    echo "\nКритическая ошибка: " . $e->getMessage() . "\n";
    exit(1);
}
?>