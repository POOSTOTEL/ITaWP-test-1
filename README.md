# Веб-приложения на PHP и MySQL с Docker

![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-3.8-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

Этот репозиторий содержит два полнофункциональных веб-приложения, разработанных в рамках контрольной работы по предмету "Интернет-технологии и веб-программирование". Оба приложения готовы к запуску в Docker-окружении.

## 🌟 Особенности

- ✅ Создание, чтение, обновление и удаление сущностей (CRUD)
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
- Порты 8000-8001 и 3306-3307 свободны

### Установка и запуск

1. **Клонируйте репозиторий**
```bash
git clone <url-репозитория>
cd itawp-test
```

2. **Запустите автоматическую установку**
```bash
cd recipes_catalog || cd task_manager
./reset.bat  # Для Windows
# или
cd recipes_catalog || cd task_manager
docker-compose up -d && php init_database.php  # Для Linux/Mac
```

3. **Откройте приложение**

Основное приложение: http://localhost:8000

phpMyAdmin: http://localhost:8081

## 📁 Структура проекта

```text
itawp-test/
├── task_manager/                # Система управления задачами
│   ├── Dockerfile               # Конфигурация PHP-контейнера
│   ├── docker-compose.yml       # Docker Compose для развертывания
│   ├── init_database.php        # Инициализация БД
│   ├── config.php               # Конфигурация подключения к БД
│   ├── index.php                # Главная страница
│   ├── add.php                  # Добавление записей
│   ├── edit.php                 # Редактирование записей
│   ├── delete.php               # Удаление записей
│   ├── update_status.php        # Обновление статуса
│   ├── test_connection.php      # Тест подключения к БД
│   ├── style.css                # Стили приложения
│   └── reset.bat                # Скрипт перезапуска для Windows
│
└── recipes_catalog/             # Каталог рецептов (вариант 15)
│   ├── Dockerfile               # Конфигурация PHP-контейнера
│   ├── docker-compose.yml       # Docker Compose для развертывания
│   ├── init_database.php        # Инициализация БД
│   ├── config.php               # Конфигурация подключения к БД
│   ├── index.php                # Главная страница
│   ├── add.php                  # Добавление рецептов
│   ├── edit.php                 # Редактирование рецептов
│   ├── delete.php               # Удаление рецептов
│   ├── update_status.php        # Обновление статуса
│   ├── test_connection.php      # Тест подключения к БД
│   ├── style.css                # Стили приложения
│   └── reset.bat                # Скрипт перезапуска для Windows
└── README.md                   # Документация
```

## 🐳 Docker сервисы
Приложения состоят из трех контейнеров:

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


### База данных ```task_manager``` и таблица ```tasks```
```sql
CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('не выполнена', 'выполнена') DEFAULT 'не выполнена',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### База данных ```recipes_catalog``` и таблица ```recipes```
```sql
 CREATE TABLE IF NOT EXISTS recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    ingredients TEXT,
    cooking_time INT,
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

📊 Описание приложений

🎯 Task Manager
Система управления задачами - базовое CRUD-приложение для организации работы с задачами.

Функциональность:

- Просмотр списка задач с сортировкой

- Добавление новых задач с описанием

- Редактирование существующих задач

- Удаление задач с подтверждением

- Изменение статуса выполнения

- Визуальное отображение статусов

🍳 Recipes Catalog
Каталог рецептов - специализированное приложение для управления кулинарными рецептами (вариант 15).

Функциональность:

- Просмотр каталога рецептов

- Добавление рецептов с ингредиентами и временем приготовления

- Редактирование рецептов

- Удаление рецептов

- Отметка рецептов как проверенных

- Отображение времени приготовления


## 🌐 API endpoints

- GET / - Просмотр всех сущностей

- POST / - Создание новых сущностей

- POST /?edit=id - Редактирование сущностей

- POST /?delete=id - Удаление сущностей

## 👨‍🎓 Автор

- БГУИР, ИТиВП, 7 семестр

- GitHub: POOSTOTEL

- Telegram: @poostotel

- Проект: Task Manager