<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mulai session
session_start();

// Include config.php
require_once 'includes/config.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: users/login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT posts.*, users.username, users.profile_picture FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC');
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<h2>Home</h2>
<a href="posts/create_post.php" class="button">Create Post</a>

<?php foreach ($posts as $post): ?>
    <div class="post">
        <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($post['profile_picture']) ?>" alt="Profile Picture" width="50">
        <h3><a href="users/profile.php?user_id=<?= $post['user_id'] ?>">@<?= htmlspecialchars($post['username']) ?></a></h3>
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        <?php if ($post['media']): ?>
            <img src="<?= BASE_URL ?>assets/media/<?= htmlspecialchars($post['media']) ?>" alt="Post Media" width="200">
        <?php endif; ?>
        <small><?= $post['created_at'] ?></small>
        <form action="posts/like_post.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <button type="submit" name="type" value="like">Like (<?= getPostLikes($post['id']) ?>)</button>
            <button type="submit" name="type" value="dislike">Dislike (<?= getPostDislikes($post['id']) ?>)</button>
        </form>
        <form action="posts/comment_post.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <textarea name="content" required></textarea>
            <button type="submit">Comment</button>
        </form>
    </div>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>