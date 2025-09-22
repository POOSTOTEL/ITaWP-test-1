# Task Manager - Менеджер задач

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-3.8-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

Простое веб-приложение для управления задачами, построенное на PHP, MySQL и Docker.

## 🌟 Особенности

- ✅ Создание, чтение, обновление и удаление задач (CRUD)
- ✅ Статусы задач: "не выполнена" и "выполнена"
- ✅ Интуитивно понятный интерфейс на Bootstrap
- ✅ Полностью контейнеризировано с Docker
- ✅ Автоматическая инициализация базы данных
- ✅ phpMyAdmin для администрирования БД
- ✅ Готовые тестовые данные

## 🚀 Быстрый старт

### Предварительные требования

- [Docker](https://www.docker.com/get-started/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- Git

### Установка и запуск

1. **Клонируйте репозиторий**
```bash
git clone <url-вашего-репозитория>
cd itawp-test
```

2. **Запустите автоматическую установку**
```bash
./reset.bat  # Для Windows
# или
docker-compose up -d && php init_database.php  # Для Linux/Mac
```

3. **Откройте приложение**

Основное приложение: http://localhost:8000

phpMyAdmin: http://localhost:8081

## 📁 Структура проекта

```text
itawp-test/
├── docker-compose.yml          # Конфигурация Docker
├── Dockerfile                  # Образ PHP приложения
├── init_database.php           # Скрипт инициализации БД
├── reset.bat                   # Скрипт переустановки (Windows)
├── index.php                   # Главная страница
├── config.php                  # Конфигурация БД
├── styles/                     # CSS стили
│   └── style.css
└── README.md                   # Документация
```

## 🐳 Docker сервисы
Приложение состоит из трех контейнеров:

### 1. MySQL Database
- Порт: 3307 (хоста) → 3306 (контейнера)
- База данных: task_manager
- Пользователь: app_user / app_password
- Root пароль: rootpassword

### 2. PHP Application
- Порт: 8000
- Платформа: PHP 8.1 + Apache
- Расширения: PDO, MySQLi

### 3. phpMyAdmin
- Порт: 8081
- Доступ: Администрирование БД через веб-интерфейс

## 🗄️ Структура базы данных

### Таблица ```tasks```
```sql
CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('не выполнена', 'выполнена') DEFAULT 'не выполнена',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🛠️ Команды управления
### Запуск приложения
```bash
docker-compose up -d
```
### Остановка приложения
```bash
docker-compose down
```
### Полная переустановка
```bash
./reset.bat  # Windows
```
### Просмотр логов
```bash
docker-compose logs mysql    # Логи MySQL
docker-compose logs app      # Логи приложения
```
### Ручная инициализация БД
```bash
php init_database.php
```

## 📝 Использование

1. Добавление задачи: Нажмите "Добавить задачу", заполните форму

2. Редактирование: Нажмите "Редактировать", отредактируйте форму

3. Изменение статуса: Используйте переключатель "Выполнена" в карточке задачи

4. Удаление: Нажмите кнопку "Удалить" в карточке задачи

## 🌐 API endpoints

- GET / - Просмотр всех задач

- POST / - Создание новой задачи

- POST /?edit=id - Редактирование задачи

- POST /?delete=id - Удаление задачи

## 👨‍🎓 Автор

- БГУИР, ИТиВП, 7 семестр

- GitHub: POOSTOTEL

- Telegram: @poostotel

- Проект: Task Manager