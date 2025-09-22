<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $ingredients = trim($_POST['ingredients']);
    $cooking_time = (int)$_POST['cooking_time'];
    
    if (!empty($title) && $cooking_time > 0) {
        $stmt = $pdo->prepare("UPDATE recipes SET title = ?, ingredients = ?, cooking_time = ? WHERE id = ?");
        $stmt->execute([$title, $ingredients, $cooking_time, $id]);
        
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать рецепт</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Редактировать рецепт</h4>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Название рецепта</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="ingredients" class="form-label">Ингредиенты</label>
                                <textarea class="form-control" id="ingredients" name="ingredients" rows="3" required><?= htmlspecialchars($recipe['ingredients']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="cooking_time" class="form-label">Время приготовления (минут)</label>
                                <input type="number" class="form-control" id="cooking_time" name="cooking_time" value="<?= htmlspecialchars($recipe['cooking_time']) ?>" min="1" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Назад</a>
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>