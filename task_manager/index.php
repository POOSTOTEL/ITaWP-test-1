<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Система управления задачами</h3>
                        <a href="add.php" class="btn btn-light">Добавить задачу</a>
                    </div>
                    <div class="card-body">
                        <?php if (count($tasks) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Задача</th>
                                            <th>Статус</th>
                                            <th>Дата создания</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tasks as $task): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?= htmlspecialchars($task['title']) ?></div>
                                                    <?php if (!empty($task['description'])): ?>
                                                        <div class="text-muted small"><?= htmlspecialchars($task['description']) ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $task['status'] == 'выполнена' ? 'success' : 'warning' ?>">
                                                        <?= $task['status'] ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d.m.Y H:i', strtotime($task['created_at'])) ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if ($task['status'] != 'выполнена'): ?>
                                                            <a href="update_status.php?id=<?= $task['id'] ?>&status=выполнена" class="btn btn-success">Выполнена</a>
                                                        <?php endif; ?>
                                                        <a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-primary">Редактировать</a>
                                                        <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Задачи не найдены. Добавьте первую задачу!</p>
                                <a href="add.php" class="btn btn-primary">Добавить задачу</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>