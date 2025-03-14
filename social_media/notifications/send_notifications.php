<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare('INSERT INTO notifications (user_id, content) VALUES (?, ?)');
    $stmt->execute([$user_id, $content]);

    header('Location: ../users/notifications.php');
    exit;
}
?>