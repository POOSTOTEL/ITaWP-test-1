<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог рецептов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">🍳 Каталог рецептов</h3>
                        <a href="add.php" class="btn btn-light">Добавить рецепт</a>
                    </div>
                    <div class="card-body">
                        <?php if (count($recipes) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Рецепт</th>
                                            <th>Ингредиенты</th>
                                            <th>Время приготовления</th>
                                            <th>Статус</th>
                                            <th>Дата добавления</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recipes as $recipe): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold"><?= htmlspecialchars($recipe['title']) ?></div>
                                                </td>
                                                <td>
                                                    <div class="text-muted small"><?= htmlspecialchars($recipe['ingredients']) ?></div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= $recipe['cooking_time'] ?> мин.</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $recipe['status'] == 'выполнена' ? 'success' : 'warning' ?>">
                                                        <?= $recipe['status'] == 'выполнена' ? 'Проверен' : 'На проверке' ?>
                                                    </span>
                                                </td>
                                                <td><?= date('d.m.Y H:i', strtotime($recipe['created_at'])) ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <?php if ($recipe['status'] != 'выполнена'): ?>
                                                            <a href="update_status.php?id=<?= $recipe['id'] ?>&status=выполнена" class="btn btn-success">Проверить</a>
                                                        <?php endif; ?>
                                                        <a href="edit.php?id=<?= $recipe['id'] ?>" class="btn btn-primary">Редактировать</a>
                                                        <a href="delete.php?id=<?= $recipe['id'] ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted">Рецепты не найдены. Добавьте первый рецепт!</p>
                                <a href="add.php" class="btn btn-success">Добавить рецепт</a>
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