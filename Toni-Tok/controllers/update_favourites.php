<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("{$root}/Toni-Tok/Database.php");

$db = new Database();

if(isset($_POST['title']) && isset($_POST['favourites'])) {
    $title = $_POST['title'];

    $favourites = $_POST['favourites'];

    $videoId = $db->query("SELECT id FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $userID = $db->query("SELECT user_id FROM createdVideos WHERE video_id = :video", ['video' => $videoId])->fetchColumn();

    $uploader = $db->query("SELECT usernames FROM users WHERE id = :user", ['user' => $userID])->fetchColumn();

    $link = $db->query("SELECT link FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $favourites = $db->query("SELECT favourites FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();

    $isFavourited = "no";

    if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
        $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

        $alreadyFavourited = $db->query("SELECT id FROM favouritedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);

        $isFavourited = count($alreadyFavourited) > 0 ? "yes" : "no";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['title'] === $title) {

        if (isset($_SESSION['user']) && $_SESSION['user'] != null) {

            $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

            $alreadyLiked = $db->query("SELECT id FROM favouritedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);

            $isFavourited = count($alreadyFavourited) > 0 ? "yes" : "no";

            $isFavourited = $isFavourited === "yes" ? "no" : "yes";

            if ($isFavourited === "yes") {
                $favourites += 1;
                $db->query("INSERT INTO favouritedVideos (user_id, video_id) VALUES (:user, :video)", ['user' => $userId, 'video' => $videoId]);
            } else {
                $favourites -= 1;
                $db->query("DELETE FROM favouritedVideos WHERE user_id = :user_id AND video_id = :video_id", ['user_id' => $userId, 'video_id' => $videoId]);
            }

            $db->query("UPDATE videos SET favourites = :favourites WHERE title = :title", [
                'favourites' => $favourites,
                'title' => $title
            ]);

            $favourites = $db->query("SELECT favourites FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
        } else {
            require("{$root}/Toni-Tok/HTML/partials/userNotLogged.php");
            die();
        }
    }
}