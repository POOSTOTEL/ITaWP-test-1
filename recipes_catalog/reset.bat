@echo off
chcp 65001 > nul

echo Остановка и очистка всех контейнеров...
docker-compose down -v

echo Удаление всех неиспользуемых данных Docker...
docker system prune -f

echo Построение образов...
docker-compose build

echo Запуск сервисов...
docker-compose up -d

echo.
echo Ожидание полного запуска MySQL (30 секунд)...
timeout /t 30

echo Проверка состояния MySQL...
docker logs task_manager_mysql

echo Инициализация базы данных...
docker exec task_manager_app php /var/www/html/init_database.php

echo.
echo ========================================
echo Система полностью переустановлена!
echo ========================================
echo.
echo Приложение доступно по адресу:
echo - PHP приложение: http://localhost:8000
echo - phpMyAdmin: http://localhost:8081