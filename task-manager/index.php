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
    <title>Менеджер задач</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .hero-section {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 1rem 1rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(94, 114, 228, 0.05);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.7em;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }
        .action-buttons {
            white-space: nowrap;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(94, 114, 228, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(45, 206, 137, 0.3);
        }
        .bg-primary {
            background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%) !important;
        }
        .bg-success {
            background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%) !important;
        }
        .bg-secondary {
            background: linear-gradient(135deg, #8898aa 0%, #9ca6b6 100%) !important;
        }
        .table-dark {
            background: linear-gradient(135deg, #344767 0%, #3a5a78 100%) !important;
        }
        .badge.bg-info {
            background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%) !important;
            color: white !important;
        }
        footer {
            margin-top: 3rem;
            padding: 2rem 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        .task-description {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nav-link.knowledge-base {
            background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%);
            border-radius: 0.5rem;
            margin-left: 1rem;
            padding: 0.5rem 1rem !important;
        }
        .nav-link.knowledge-base:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(45, 206, 137, 0.3);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #344767 0%, #3a5a78 100%);">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-check2-circle me-2"></i>Менеджер задач
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-house me-1"></i>Главная
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">
                            <i class="bi bi-plus-circle me-1"></i>Добавить задачу
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link knowledge-base" href="../knowledge-base/index.php" target="_blank">
                            <i class="bi bi-journal-bookmark me-1"></i>База знаний
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="bi bi-list-task me-2"></i>Менеджер задач
            </h1>
            <p class="lead">Организуйте ваши задачи эффективно</p>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-list-check me-2"></i>Всего задач
                        </h5>
                        <h3 class="card-text"><?= count($tasks) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-check-circle me-2"></i>Выполнено
                        </h5>
                        <h3 class="card-text">
                            <?= count(array_filter($tasks, fn($task) => $task['status'] === 'выполнена')) ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-hourglass-split me-2"></i>В процессе
                        </h5>
                        <h3 class="card-text">
                            <?= count(array_filter($tasks, fn($task) => $task['status'] === 'не выполнена')) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>
                <i class="bi bi-list-ul me-2"></i>Список задач
            </h2>
            <a href="add.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Добавить задачу
            </a>
        </div>

        <?php if ($tasks): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-card-heading me-1"></i>Название</th>
                            <th><i class="bi bi-text-paragraph me-1"></i>Описание</th>
                            <th><i class="bi bi-circle-fill me-1"></i>Статус</th>
                            <th><i class="bi bi-calendar me-1"></i>Дата создания</th>
                            <th><i class="bi bi-gear me-1"></i>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($task['id']) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($task['title']) ?></strong>
                                </td>
                                <td class="task-description" title="<?= htmlspecialchars($task['description']) ?>">
                                    <?= $task['description'] ? htmlspecialchars(mb_substr($task['description'], 0, 50)) . '...' : '—' ?>
                                </td>
                                <td>
                                    <?php if ($task['status'] == 'выполнена'): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i><?= htmlspecialchars($task['status']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-hourglass-split me-1"></i><?= htmlspecialchars($task['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= date('d.m.Y H:i', strtotime($task['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="action-buttons">
                                    <a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-warning" title="Редактировать">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить эту задачу?')" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php if ($task['status'] == 'не выполнена'): ?>
                                        <a href="update_status.php?id=<?= $task['id'] ?>&status=выполнена" class="btn btn-sm btn-primary" title="Отметить выполненной">
                                            <i class="bi bi-check-circle"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="update_status.php?id=<?= $task['id'] ?>&status=не выполнена" class="btn btn-sm btn-secondary" title="Вернуть в работу">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="card">
                    <div class="card-body py-5">
                        <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                        <h3 class="text-muted">Задач не найдено</h3>
                        <p class="text-muted">Начните с добавления первой задачи</p>
                        <a href="add.php" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-1"></i>Добавить первую задачу
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm('Вы уверены, что хотите удалить эту задачу?');
        }
        
        document.querySelectorAll('a[href*="delete.php"]').forEach(link => {
            link.addEventListener('click', confirmDelete);
        });
    </script>
</body>
</html>
