<?php
session_start();
include '../includes/config.php';

if (!isset($_GET['query'])) {
    header('Location: ../index.php');
    exit;
}

$query = '%' . $_GET['query'] . '%';
$stmt = $pdo->prepare('SELECT * FROM users WHERE username LIKE ? OR full_name LIKE ?');
$stmt->execute([$query, $query]);
$users = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<h2>Search Results</h2>
<?php if (count($users) > 0): ?>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <a href="profile.php?user_id=<?= $user['id'] ?>">@<?= htmlspecialchars($user['username']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>