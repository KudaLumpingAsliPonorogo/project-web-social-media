<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

if (!isset($_GET['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$user_id = $_GET['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: ../index.php');
    exit;
}

$is_following = isFollowing($_SESSION['user_id'], $user_id);
?>

<h2>Profile</h2>
<div class="profile-info">
    <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Profile Picture" class="profile-picture">
    <p><strong>Username:</strong> @<?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
    <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($user['bio'])) ?></p>
</div>

<?php if ($is_following): ?>
    <form action="unfollow.php" method="POST">
        <input type="hidden" name="following_id" value="<?= $user_id ?>">
        <button type="submit">Unfollow</button>
    </form>
<?php else: ?>
    <form action="follow.php" method="POST">
        <input type="hidden" name="following_id" value="<?= $user_id ?>">
        <button type="submit">Follow</button>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>