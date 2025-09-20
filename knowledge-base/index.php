<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>База знаний</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: linear-gradient(135deg, #344767 0%, #3a5a78 100%);">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-journal-bookmark-fill me-2"></i>База знаний
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
                        <i class="bi bi-plus-circle me-1"></i>Добавить статью
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../task-manager/index.php" style="background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%); border-radius: 0.5rem; margin-left: 1rem; padding: 0.5rem 1rem !important;">
                        <i class="bi bi-check2-circle me-1"></i>Менеджер задач
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                <i class="bi bi-journal-text me-2"></i>База знаний
            </h1>
            <p class="lead">Управляйте вашими статьями и знаниями в одном месте</p>
        </div>
    </div>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-journal me-2"></i>Всего статей
                        </h5>
                        <h3 class="card-text"><?= count($articles) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-check-circle me-2"></i>Опубликовано
                        </h5>
                        <h3 class="card-text">
                            <?= count(array_filter($articles, fn($article) => $article['status'] === 'опубликована')) ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-pencil me-2"></i>Черновики
                        </h5>
                        <h3 class="card-text">
                            <?= count(array_filter($articles, fn($article) => $article['status'] === 'черновик')) ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>
                <i class="bi bi-list-ul me-2"></i>Список статей
            </h2>
            <a href="add.php" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i>Добавить статью
            </a>
        </div>

        <?php if ($articles): ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-bookmark me-1"></i>Название</th>
                            <th><i class="bi bi-tags me-1"></i>Ключевые слова</th>
                            <th><i class="bi bi-circle-fill me-1"></i>Статус</th>
                            <th><i class="bi bi-calendar me-1"></i>Дата создания</th>
                            <th><i class="bi bi-gear me-1"></i>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($article['id']) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($article['title']) ?></strong>
                                    <?php if ($article['description']): ?>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars(mb_substr($article['description'], 0, 50)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($article['keywords']): ?>
                                        <?php foreach (explode(',', $article['keywords']) as $keyword): ?>
                                            <span class="badge bg-info me-1 mb-1"><?= trim(htmlspecialchars($keyword)) ?></span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($article['status'] == 'опубликована'): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i><?= htmlspecialchars($article['status']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-pencil me-1"></i><?= htmlspecialchars($article['status']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        <?= date('d.m.Y H:i', strtotime($article['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="action-buttons">
                                    <a href="edit.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-warning" title="Редактировать">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить эту статью?')" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php if ($article['status'] == 'черновик'): ?>
                                        <a href="update_status.php?id=<?= $article['id'] ?>&status=опубликована" class="btn btn-sm btn-primary" title="Опубликовать">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="update_status.php?id=<?= $article['id'] ?>&status=черновик" class="btn btn-sm btn-secondary" title="В черновик">
                                            <i class="bi bi-eye-slash"></i>
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
                        <i class="bi bi-journal-x display-1 text-muted mb-3"></i>
                        <h3 class="text-muted">Статей не найдено</h3>
                        <p class="text-muted">Начните с добавления первой статьи в вашу базу знаний</p>
                        <a href="add.php" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-circle me-1"></i>Добавить первую статью
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm('Вы уверены, что хотите удалить эту статью?');
        }
        
        document.querySelectorAll('a[href*="delete.php"]').forEach(link => {
            link.addEventListener('click', confirmDelete);
        });
    </script>
</body>
</html>