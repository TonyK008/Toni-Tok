<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php session_start();
        $root = $_SERVER['DOCUMENT_ROOT'];
        require "{$root}/Toni-Tok/HTML/partials/icon.php"
    ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/Database.php");
        ?>
    </style>
</head>
<body>
    <?php require('navigation.php') ?>

    <div id="profilePicture" style="<?php
            if(isset($_SESSION['user']) && $_SESSION['user'] != null){
                $db = new Database();
                $result = $db->query("SELECT * FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']]) -> fetchAll(PDO::FETCH_ASSOC);
                if(count($result) > 0){
                    $profile_picture = $db->query("SELECT profile_pictures FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']]) -> fetchColumn();
                    $image_data = base64_encode($profile_picture);

                    echo("background-image: url('data:image/jpeg;base64,{$image_data}')");

                }
            } else{
                    echo("background-image: url(/Toni-Tok/HTML/images/unlogged.png)");
            }?>">
    </div>
    <center><p id="usernameLabel"><?= $_SESSION['user']['username'] ?></p></center>
    
    <hr>

    <div id='profileControlsContainer'>
        <center><a href="/Toni-Tok/controllers/profile.php"><button class='profileControls' id='allVideosControl'></button></a></center>
        <center><a><button class='profileControls' id='likedVideosControl' style="background-image: <?= pageURL("/Toni-Tok/HTML/partials/likedVideosDisplay.php") ? "url(/Toni-Tok/HTML/images/unlikedAfter.png)" : "url(/Toni-Tok/HTML/images/unliked.png)"?>"></button></a></center>
        <center><a href="/Toni-Tok/HTML/partials/favouritedVideosDisplay.php"><button class='profileControls' id='favouritedVideosControl'></button></a></center>
    </div>

    <div id="likedVideosContainer">
        <?php

            $db = new Database();

            $currentUser = $_SESSION['user']['username'];

            $userId = $db -> query("SELECT id FROM users WHERE usernames = :username", [
                'username' => $currentUser
            ]) -> fetchColumn();

            $allLikedVideos = $db -> query("SELECT video_id FROM likedVideos WHERE user_id = :userID", [
                'userID' => $userId
            ]) -> fetchAll(PDO::FETCH_COLUMN);
        
            foreach($allLikedVideos as $likedVideo){
                $video_id = $db -> query("SELECT id FROM videos WHERE id = :video_id", [
                    'video_id' => $likedVideo
                ]) -> fetchColumn();
                require("currentVideo.php");
            }
        ?>

    </div>

</body>
</html>
