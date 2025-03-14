<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<h2>Notifications</h2>
<?php if (count($notifications) > 0): ?>
    <ul>
        <?php foreach ($notifications as $notification): ?>
            <li>
                <p><?= htmlspecialchars($notification['content']) ?></p>
                <small><?= $notification['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No notifications found.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>