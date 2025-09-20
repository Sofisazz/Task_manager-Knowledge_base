<?php
require_once 'config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $newStatus = $_GET['status'];

    $sql = "UPDATE articles SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newStatus, $id]);
}

header('Location: index.php');
exit();
?>