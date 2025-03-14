<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $follower_id = $_SESSION['user_id'];
    $following_id = $_POST['following_id'];

    $stmt = $pdo->prepare('INSERT INTO followers (follower_id, following_id) VALUES (?, ?)');
    $stmt->execute([$follower_id, $following_id]);

    header('Location: ../users/profile.php?user_id=' . $following_id);
    exit;
}
?>