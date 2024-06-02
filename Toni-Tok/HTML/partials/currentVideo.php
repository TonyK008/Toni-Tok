<?php

$link = $db->query("SELECT link FROM videos WHERE id = :video_id", [
    'video_id' => $video_id
])->fetchColumn();

$likes = $db->query("SELECT likes FROM videos WHERE id = :video_id", [
    'video_id' => $video_id
])->fetchColumn();

$isLiked = "no";

$alreadyLiked = $db -> query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", [
    'user' => $userId,
    'video' => $video_id
]) -> fetchAll(PDO::FETCH_ASSOC);

if(count($alreadyLiked) > 0){
    $isLiked = "yes";
}else{
    $isLiked = "no";
}

$title = $db -> query("SELECT title FROM videos WHERE id = :video", [
    'video' => $video_id
]) -> fetchColumn();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['title'] === $title) {

if(isset($_SESSION['user'])){

    $currentUser = $_SESSION['user']['username'];

    $videoId = $db -> query("SELECT id FROM videos WHERE id = :video_id", [
        'video_id' => $video_id
    ])->fetchColumn();

    $userId = $db -> query("SELECT id FROM users WHERE id = :video_id", [
        'video_id' => $video_id
    ])->fetchColumn();

    $videoId = $db -> query("SELECT id FROM videos WHERE id = :video_id", [
        'video_id' => $video_id
    ])->fetchColumn();

    $alreadyLiked = $db -> query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", [
        'user' => $userId,
        'video' => $videoId
    ]) -> fetchAll(PDO::FETCH_ASSOC);

    if(count($alreadyLiked) > 0){
        $isLiked = "yes";
    }else{
        $isLiked = "no";
    }

    $isLiked = $isLiked === "yes" ? "no" : "yes";

        $currentUser = $_SESSION['user']['username'];

        $userId = $db -> query("SELECT id FROM users WHERE usernames = :username", [
            'username' => $currentUser
        ]) -> fetchColumn();

        $videoId = $db -> query("SELECT id FROM videos WHERE title = :title", [
            'title' => $title
        ]) -> fetchColumn();

        if ($isLiked === "yes") {
            $likes -= 1;
            $db->query("DELETE FROM LikedVideos WHERE user_id = :user_id AND video_id = :video_id", [
                'user_id' => $userId,
                'video_id' => $videoId
            ]);
        } else {
            $likes += 1;
            $db -> query("INSERT INTO likedVideos (user_id, video_id) VALUES (:user, :video)", [
                'user' => $userId,
                'video' => $videoId
            ]);
        }

    $db->query("UPDATE videos SET likes = :likes WHERE title = :title", [
        'likes' => $likes,
        'title' => $title
    ]);

    $alreadyLiked = $db -> query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", [
        'user' => $userId,
        'video' => $videoId
    ]) -> fetchAll(PDO::FETCH_ASSOC);

    if(count($alreadyLiked) > 0){
        $isLiked = "yes";
    }else{
        $isLiked = "no";
    }
}
        
}
?>
<center>
    <div class='likedVideosDisplayer' style="position: relative; display: block;">
        <iframe class='likedVideosDisplayer' src="https://www.youtube.com/embed/<?= $link ?>?playlist=<?= $link ?>&loop=1"></iframe>
        <a  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;" href="<?= "/Toni-Tok/HTML/partials/profileVideos.php?u_id={$userId}&v_id={$video_id}" ?>"></a>
    </div>
</center>
