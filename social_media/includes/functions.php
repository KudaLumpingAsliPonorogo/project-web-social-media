<?php
function isFollowing($follower_id, $following_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM followers WHERE follower_id = ? AND following_id = ?');
    $stmt->execute([$follower_id, $following_id]);
    return $stmt->fetch();
}

function getPostLikes($post_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT COUNT(*) as likes FROM likes WHERE post_id = ? AND type = "like"');
    $stmt->execute([$post_id]);
    return $stmt->fetch()['likes'];
}

function getPostDislikes($post_id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT COUNT(*) as dislikes FROM likes WHERE post_id = ? AND type = "dislike"');
    $stmt->execute([$post_id]);
    return $stmt->fetch()['dislikes'];
}
?>