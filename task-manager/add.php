<?php
require_once 'config.php';

$error = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'не выполнена';

    if (empty($title)) {
        $error['title'] = "Название задачи обязательно для заполнения.";
    } elseif (strlen($title) > 255) {
        $error['title'] = "Название не должно превышать 255 символов.";
    } elseif (preg_match('/^\d/', $title)) {
        $error['title'] = "Название не может начинаться с цифры.";
    } elseif (!preg_match('/^[a-zA-Zа-яА-Я0-9\s\-_,.!?()"\'«»„“”:]+$/u', $title)) {
        $error['title'] = "Название содержит недопустимые символы (разрешены буквы, цифры, пробелы, дефис, запятая, точка, ! ? ( )).";
    }

    if (strlen($description) > 2000) {
        $error['description'] = "Описание не должно превышать 2000 символов.";
    }

    if (empty($error)) {
        $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

        try {
            $sql = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $description, $status]);

            header('Location: index.php?success=1');
            exit();
        } catch (Exception $e) {
            $error['general'] = "Ошибка при сохранении задачи. Попробуйте позже.";
        }
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
        .invalid-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-control.is-invalid {
            border-color: #dc3545 !important;
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

                    <?php if (isset($error['general'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($error['general'], ENT_QUOTES, 'UTF-8') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" id="taskForm">
                        <div class="mb-4">
                            <label for="title" class="form-label required-field">
                                <i class="bi bi-card-heading me-1"></i>Название задачи
                            </label>
                            <input type="text" maxlength="255"
                                   class="form-control <?= isset($error['title']) ? 'is-invalid' : '' ?>"
                                   id="title" name="title"
                                   placeholder="Введите название задачи (не начинайте с цифры)"
                                   value="<?= htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                   required>
                            <div class="character-count" id="title-count">0/255</div>
                            <div class="invalid-feedback"></div>
                            <?php if (isset($error['title'])): ?>
                                <div class="invalid-feedback d-block"><?= htmlspecialchars($error['title'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>Описание задачи
                            </label>
                            <textarea class="form-control <?= isset($error['description']) ? 'is-invalid' : '' ?>"
                                      id="description" name="description" rows="4" maxlength="2000"
                                      placeholder="Описание задачи (необязательно)"><?= htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            <div class="character-count" id="description-count">0 символов</div>
                            <div class="invalid-feedback"></div>
                            <?php if (isset($error['description'])): ?>
                                <div class="invalid-feedback d-block"><?= htmlspecialchars($error['description'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="bi bi-circle-fill me-1"></i>Статус задачи
                            </label>
                            <select class="form-select" id="status" name="status">
                                <option value="не выполнена" <?= (($_POST['status'] ?? 'не выполнена') == 'не выполнена') ? 'selected' : '' ?>>
                                    Не выполнена
                                </option>
                                <option value="выполнена" <?= (($_POST['status'] ?? 'не выполнена') == 'выполнена') ? 'selected' : '' ?>>
                                    Выполнена
                                </option>
                            </select>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="index.php" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
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
    document.addEventListener('DOMContentLoaded', function() {

        function setupFieldValidation(inputId, counterId, maxLength = null, validator = null) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            const feedback = input.closest('.mb-4').querySelector('.invalid-feedback');

            function updateCounter() {
                const len = input.value.length;
                if (maxLength) {
                    counter.textContent = `${len}/${maxLength}`;
                    counter.style.color = len > maxLength * 0.8 ? '#dc3545' : '#6c757d';
                } else {
                    counter.textContent = `${len} символов`;
                }
            }

            function clearError() {
                input.classList.remove('is-invalid');
                if (feedback) {
                    feedback.textContent = '';
                    feedback.classList.remove('d-block');
                }
            }

            function showError(message) {
                input.classList.add('is-invalid');
                if (feedback) {
                    feedback.textContent = message;
                    feedback.classList.add('d-block');
                }
            }

            function validate() {
                if (validator) {
                    const errorMsg = validator(input.value);
                    if (errorMsg) {
                        showError(errorMsg);
                        return false;
                    } else {
                        clearError();
                        return true;
                    }
                }
                clearError();
                return true;
            }

            input.addEventListener('input', function() {
                updateCounter();
                validate();
            });

            input.addEventListener('focus', function() {
                if (input.classList.contains('is-invalid')) {
                    validate();
                }
            });

            updateCounter();

            return {
                element: input,
                validate: validate
            };
        }

        function validateTitle(value) {
            if (value.trim() === '') return "Название задачи обязательно.";
            if (/^\d/.test(value)) return "Название не может начинаться с цифры.";
            if (!/^[a-zA-Zа-яА-Я0-9\s\-_,.!?()"'«»„“”:]+$/u.test(value))
                return "Недопустимые символы. Разрешены: буквы, цифры, пробелы, дефис, запятая, точка, ! ? ( ) \" ' « » „ “ ”";
            if (value.length > 255) return "Название не должно превышать 255 символов.";
            return null;
        }

        function validateDescription(value) {
            if (value.length > 2000) return "Описание не должно превышать 2000 символов.";
            return null;
        }

        const titleField = setupFieldValidation('title', 'title-count', 255, validateTitle);
        const descriptionField = setupFieldValidation('description', 'description-count', 2000, validateDescription);

        let formChanged = false;
        const form = document.getElementById('taskForm');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(el => {
            el.addEventListener('input', () => formChanged = true);
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        form.addEventListener('submit', function(e) {
            let isValid = true;

            if (!titleField.validate()) isValid = false;
            if (!descriptionField.validate()) isValid = false;

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            formChanged = false;
        });

    });
</script>
</body>
</html>