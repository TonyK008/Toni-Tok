<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("{$root}/Toni-Tok/Database.php");

$db = new Database();

if(isset($_POST['title']) && isset($_POST['comment']) && $_POST['comment'] != null) {
    $title = $_POST['title'];
    $currentUser = $_SESSION['user']['username'];
    $userId = $db -> query("SELECT id FROM users WHERE usernames = :user", ['user' => $currentUser]) -> fetchColumn();
    $videoId = $db -> query("SELECT id FROM videos WHERE title = :title", ['title' => $title]) -> fetchColumn();
    $comment = $_POST['comment'];
    $commentUploader = $currentUser;

    $db -> query("INSERT INTO comments (user_id, video_id, comment) VALUES (:user, :video, :comment)", [
        'user' => $userId,
        'video' => $videoId,
        'comment' => $comment
    ]);

    $comments = $db -> query("SELECT comment FROM comments WHERE video_id = :video", ['video' => $videoId]) -> fetchAll(PDO::FETCH_COLUMN);
    $profile_picture = $db->query("SELECT profile_pictures FROM users WHERE usernames = :username", ['username' => $commentUploader]) -> fetchColumn();
    $image_data = base64_encode($profile_picture);

    $data = [
        'comments' => $comments,
        'commentsCount' => $commentsCount
    ];

    echo json_encode($data);
}