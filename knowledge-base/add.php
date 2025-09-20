<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $content = htmlspecialchars(trim($_POST['content']));
    $keywords = htmlspecialchars(trim($_POST['keywords']));
    $status = $_POST['status'];

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO articles (title, description, content, keywords, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $content, $keywords, $status]);

        header('Location: index.php');
        exit();
    } else {
        $error = "Название и содержание статьи обязательны для заполнения!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить новую статью</title>
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
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: linear-gradient(135deg, #344767 0%, #3a5a78 100%);">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-journal-bookmark-fill me-2"></i>База знаний
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
                <i class="bi bi-plus-circle me-2"></i>Добавить новую статью
            </h1>
            <p class="lead">Создайте новую статью для вашей базы знаний</p>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
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
                                <i class="bi bi-bookmark me-1"></i>Название статьи
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   placeholder="Введите название статьи" required>
                            <div class="character-count" id="title-count">0/255</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>Краткое описание
                            </label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3" placeholder="Краткое описание статьи (необязательно)"></textarea>
                            <div class="character-count" id="description-count">0 символов</div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label required-field">
                                <i class="bi bi-file-text me-1"></i>Содержание статьи
                            </label>
                            <textarea class="form-control" id="content" name="content" 
                                      rows="8" placeholder="Полное содержание статьи" required></textarea>
                            <div class="character-count" id="content-count">0 символов</div>
                        </div>

                        <div class="mb-4">
                            <label for="keywords" class="form-label">
                                <i class="bi bi-tags me-1"></i>Ключевые слова
                            </label>
                            <input type="text" class="form-control" id="keywords" name="keywords" 
                                   placeholder="Введите ключевые слова через запятую">
                            <div class="form-text">Например: PHP, MySQL, оптимизация, установка, разработка</div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-circle-fill me-1"></i>Статус статьи
                            </label>
                            <select class="form-select" id="status" name="status">
                                <option value="черновик">
                                    <i class="bi bi-pencil"></i> Черновик
                                </option>
                                <option value="опубликована">
                                    <i class="bi bi-check-circle"></i> Опубликована
                                </option>
                            </select>
                        </div>

                        <!-- Кнопки -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Добавить статью
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Функция для подсчета символов
        function setupCharacterCounter(textareaId, counterId, maxLength = null) {
            const textarea = document.getElementById(textareaId);
            const counter = document.getElementById(counterId);
            
            function updateCount() {
                const length = textarea.value.length;
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
            
            textarea.addEventListener('input', updateCount);
            updateCount(); // Инициализация при загрузке
        }

        // Инициализация счетчиков символов
        document.addEventListener('DOMContentLoaded', function() {
            setupCharacterCounter('title', 'title-count', 255);
            setupCharacterCounter('description', 'description-count');
            setupCharacterCounter('content', 'content-count');
            
            // Подсказка при попытке уйти со страницы без сохранения
            let formChanged = false;
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    formChanged = true;
                });
            });
            
            window.addEventListener('beforeunload', (e) => {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            
            form.addEventListener('submit', () => {
                formChanged = false;
            });
        });
    </script>
</body>
</html>