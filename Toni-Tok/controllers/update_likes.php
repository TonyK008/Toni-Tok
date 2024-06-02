<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("{$root}/Toni-Tok/Database.php");

$db = new Database();

if(isset($_POST['title']) && isset($_POST['likes'])) {
    $title = $_POST['title'];
    $likes = $_POST['likes'];

    $videoId = $db->query("SELECT id FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $userID = $db->query("SELECT user_id FROM createdVideos WHERE video_id = :video", ['video' => $videoId])->fetchColumn();

    $uploader = $db->query("SELECT usernames FROM users WHERE id = :user", ['user' => $userID])->fetchColumn();

    $link = $db->query("SELECT link FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $likes = $db->query("SELECT likes FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $isLiked = "no";

    if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
        $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

        $alreadyLiked = $db->query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);

        $isLiked = count($alreadyLiked) > 0 ? "yes" : "no";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['title'] === $title) {

        if (isset($_SESSION['user']) && $_SESSION['user'] != null) {

            $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

            $alreadyLiked = $db->query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);

            $isLiked = count($alreadyLiked) > 0 ? "yes" : "no";

            $isLiked = $isLiked === "yes" ? "no" : "yes";

            if ($isLiked === "yes") {
                $likes += 1;
                $db->query("INSERT INTO likedVideos (user_id, video_id) VALUES (:user, :video)", ['user' => $userId, 'video' => $videoId]);
            } else {
                $likes -= 1;
                $db->query("DELETE FROM LikedVideos WHERE user_id = :user_id AND video_id = :video_id", ['user_id' => $userId, 'video_id' => $videoId]);
            }

            $db->query("UPDATE videos SET likes = :likes WHERE title = :title", [
                'likes' => $likes,
                'title' => $title
            ]);

            $likes = $db->query("SELECT likes FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
        } else {
            require("{$root}/Toni-Tok/HTML/partials/userNotLogged.php");
            die();
        }
    }
}