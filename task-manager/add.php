<?php
// add.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $status = $_POST['status'];

    if (!empty($title)) {
        $sql = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $status]);

        header('Location: index.php');
        exit();
    } else {
        $error = "Название задачи обязательно для заполнения!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .add-header {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }
        .form-container {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #5e72e4;
            box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(94, 114, 228, 0.3);
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        .character-count {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: right;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #344767 0%, #3a5a78 100%);">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-check2-circle me-2"></i>Менеджер задач
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">
                    <i class="bi bi-arrow-left me-1"></i>Назад к списку
                </a>
            </div>
        </div>
    </nav>

    <div class="add-header">
        <div class="container text-center">
            <h1 class="display-5 fw-bold">
                <i class="bi bi-plus-circle me-2"></i>Добавить задачу
            </h1>
            <p class="lead">Создайте новую задачу</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-4">
                            <label for="title" class="form-label required-field">
                                <i class="bi bi-card-heading me-1"></i>Название задачи
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   placeholder="Введите название задачи" required>
                            <div class="character-count" id="title-count">0/255</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>Описание задачи
                            </label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" placeholder="Описание задачи (необязательно)"></textarea>
                            <div class="character-count" id="description-count">0 символов</div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-circle-fill me-1"></i>Статус задачи
                            </label>
                            <select class="form-select" id="status" name="status">
                                <option value="не выполнена">Не выполнена</option>
                                <option value="выполнена">Выполнена</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Добавить задачу
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setupCharacterCounter(inputId, counterId, maxLength = null) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            
            function updateCount() {
                const length = input.value.length;
                if (maxLength) {
                    counter.textContent = `${length}/${maxLength}`;
                    if (length > maxLength * 0.8) {
                        counter.style.color = '#dc3545';
                    } else {
                        counter.style.color = '#6c757d';
                    }
                } else {
                    counter.textContent = `${length} символов`;
                }
            }
            
            input.addEventListener('input', updateCount);
            updateCount();
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupCharacterCounter('title', 'title-count', 255);
            setupCharacterCounter('description', 'description-count');
        });
    </script>
</body>
</html>