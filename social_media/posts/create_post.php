<?php
require_once '../includes/config.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $media = null;

    if ($_FILES['media']['error'] == 0) {
        $target_dir = "../assets/media/";
        $target_file = $target_dir . basename($_FILES['media']['name']);
        move_uploaded_file($_FILES['media']['tmp_name'], $target_file);
        $media = basename($_FILES['media']['name']);
    }

    $stmt = $pdo->prepare('INSERT INTO posts (user_id, content, media) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, $content, $media]);

    header('Location: ../index.php');
    exit;
}
?>

<h2>Create Post</h2>
<form method="POST" enctype="multipart/form-data">
    <textarea name="content" required></textarea>
    <input type="file" name="media" accept="image/*, video/*">
    <button type="submit">Post</button>
</form>

<?php include '../includes/footer.php'; ?>