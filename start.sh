#!/bin/bash

echo "Запуск MySQL в Docker..."
docker-compose up -d

echo "Ожидание запуска MySQL..."
sleep 10

echo "Проверка соединения с базой данных..."
php test_connection.php

echo "Приложение готово к работе!"
echo "PHP приложение: http://localhost"
echo "phpMyAdmin: http://localhost:8080"
echo "MySQL: localhost:3306"