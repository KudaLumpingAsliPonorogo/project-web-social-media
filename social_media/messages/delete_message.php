<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_id = $_POST['message_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('SELECT * FROM messages WHERE id = ? AND receiver_id = ?');
    $stmt->execute([$message_id, $user_id]);
    $message = $stmt->fetch();

    if ($message) {
        $stmt = $pdo->prepare('DELETE FROM messages WHERE id = ?');
        $stmt->execute([$message_id]);
    }

    header('Location: ../messages/view_messages.php');
    exit;
}
?>