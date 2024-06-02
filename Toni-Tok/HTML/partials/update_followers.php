<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("{$root}/Toni-Tok/Database.php");

$db = new Database();

if(isset($_GET['follower']) && isset($_GET['following'])) {
    $follower = $_GET['follower'];
    $following = $_GET['following'];

    $followerID = $db->query("SELECT id FROM users WHERE usernames = :user", ['user' => $follower])->fetchColumn();

    $isFollowing = "no";

    if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
        $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

        $alreadyFollowing = $db->query("SELECT id FROM followed WHERE user_id = :following AND follower_id = :follower", ['following' => $following, 'follower' => $userId])->fetchAll(PDO::FETCH_ASSOC);

        $isFollowing = count($alreadyFollowing) > 0 ? "yes" : "no";
    }

    if (isset($_SESSION['user']) && $_SESSION['user'] != null) {

        $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();

        $alreadyFollowing = $db->query("SELECT id FROM followed WHERE user_id = :follow AND follower_id = :follower", ['follow' => $following, 'follower' => $userId])->fetchAll(PDO::FETCH_ASSOC);

        $isFollowing = count($alreadyFollowing) > 0 ? "yes" : "no";

        $isFollowing = $isFollowing === "yes" ? "no" : "yes";

        if ($isFollowing === "yes") {
            $db->query("INSERT INTO followed (user_id, follower_id) VALUES (:follow, :follower)", ['follow' => $following, 'follower' => $userId]);
        } else {
            $db->query("DELETE FROM followed WHERE user_id = :follow AND follower_id = :follower", ['follow' => $following, 'follower' => $userId]);
        }

    } else {
        require("{$root}/Toni-Tok/HTML/partials/userNotLogged.php");
        die();
    }
}