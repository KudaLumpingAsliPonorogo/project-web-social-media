<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../users/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $bio = $_POST['bio'];

    if ($_FILES['profile_picture']['error'] == 0) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
        $profile_picture = basename($_FILES['profile_picture']['name']);
    } else {
        $profile_picture = $user['profile_picture'];
    }

    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, bio = ?, profile_picture = ? WHERE id = ?');
    $stmt->execute([$full_name, $bio, $profile_picture, $user_id]);

    header('Location: profile.php');
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<h2>Edit Profile</h2>
<form method="POST" enctype="multipart/form-data">
    <label for="full_name">Full Name:</label>
    <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

    <label for="bio">Bio:</label>
    <textarea id="bio" name="bio"><?= htmlspecialchars($user['bio']) ?></textarea>

    <label for="profile_picture">Profile Picture:</label>
    <input type="file" id="profile_picture" name="profile_picture">

    <button type="submit">Save Changes</button>
</form>
<?php include '../includes/footer.php'; ?>