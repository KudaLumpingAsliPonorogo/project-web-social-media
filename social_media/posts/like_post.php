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
    $type = $_POST['type'];

    $stmt = $pdo->prepare('SELECT * FROM likes WHERE post_id = ? AND user_id = ?');
    $stmt->execute([$post_id, $user_id]);
    $like = $stmt->fetch();

    if ($like) {
        $stmt = $pdo->prepare('UPDATE likes SET type = ? WHERE id = ?');
        $stmt->execute([$type, $like['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO likes (post_id, user_id, type) VALUES (?, ?, ?)');
        $stmt->execute([$post_id, $user_id, $type]);
    }

    header('Location: ../index.php');
    exit;
}
?>