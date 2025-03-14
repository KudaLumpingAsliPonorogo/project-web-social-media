<?php
session_start();
include '../includes/config.php';

if (!isset($_GET['post_id'])) {
    header('Location: ../index.php');
    exit;
}

$post_id = $_GET['post_id'];
$stmt = $pdo->prepare('SELECT posts.*, users.username, users.profile_picture FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?');
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at DESC');
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<h2>Post by @<?= htmlspecialchars($post['username']) ?></h2>
<div class="post">
    <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($post['profile_picture']) ?>" alt="Profile Picture" width="50">
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <?php if ($post['media']): ?>
        <img src="<?= BASE_URL ?>assets/media/<?= htmlspecialchars($post['media']) ?>" alt="Post Media" width="200">
    <?php endif; ?>
    <small><?= $post['created_at'] ?></small>
    <form action="like_post.php" method="POST">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <button type="submit" name="type" value="like">Like</button>
        <button type="submit" name="type" value="dislike">Dislike</button>
    </form>
    <form action="comment_post.php" method="POST">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <textarea name="content" required></textarea>
        <button type="submit">Comment</button>
    </form>
</div>

<h3>Comments</h3>
<?php if (count($comments) > 0): ?>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li>
                <p><strong>@<?= htmlspecialchars($comment['username']) ?></strong>: <?= htmlspecialchars($comment['content']) ?></p>
                <small><?= $comment['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No comments yet.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>