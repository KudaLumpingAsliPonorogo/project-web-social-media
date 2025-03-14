<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blocker_id = $_SESSION['user_id'];
    $blocked_id = $_POST['blocked_id'];

    $stmt = $pdo->prepare('INSERT INTO blocks (blocker_id, blocked_id) VALUES (?, ?)');
    $stmt->execute([$blocker_id, $blocked_id]);

    header('Location: ../users/profile.php?user_id=' . $blocked_id);
    exit;
}
?>