CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE IF NOT EXISTS tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('не выполнена', 'выполнена') DEFAULT 'не выполнена',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tasks (title, description, status) VALUES
('Изучить PHP', 'Освоить основы PHP', 'не выполнена'),
('Создать веб-приложение', 'Разработать Task Manager', 'не выполнена'),
('Изучить Bootstrap', 'Освоить Bootstrap', 'выполнена');