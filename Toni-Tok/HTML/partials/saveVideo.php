<?php

$root = $_SERVER['DOCUMENT_ROOT'];

$db = new Database();

$title = $_POST['title'];
$link = $_POST['link'];
$tag = $_POST['tag'];

$db -> query("INSERT INTO videos(title, link, tag) VALUES('{$title}', '{$link}', '{$tag}')");

$currentUser = $_SESSION['user']['username'];

$userId = $db -> query("SELECT id FROM users WHERE usernames = :currUser", [
    'currUser' => $currentUser
]) -> fetchColumn();

$videoId = $db -> query("SELECT id FROM videos WHERE title = '$title'") -> fetchColumn();

$db -> query("INSERT INTO createdVideos(user_id, video_id) VALUES(:user, :video)", [
    'user' => $userId,
    'video' => $videoId
]);