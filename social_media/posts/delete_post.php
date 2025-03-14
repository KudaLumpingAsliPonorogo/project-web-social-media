<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('SELECT * FROM posts WHERE id = ? AND user_id = ?');
    $stmt->execute([$post_id, $user_id]);
    $post = $stmt->fetch();

    if ($post) {
        $stmt = $pdo->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$post_id]);
    }

    header('Location: ../index.php');
    exit;
}
?>