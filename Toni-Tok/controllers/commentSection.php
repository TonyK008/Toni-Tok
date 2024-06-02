<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php session_start(); $root = $_SERVER['DOCUMENT_ROOT'];require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/form.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        require("{$root}/Toni-Tok/Database.php"); 
        $db = new Database();
        ?>
    </style>
</head>
<body>
<?php

if(isset($_GET['title'])) {
    $title = $_GET['title'];

    $videoID = $db -> query("SELECT id FROM videos WHERE title = :title", ['title' => $title]) -> fetchColumn();
    $comments = $db -> query("SELECT comment FROM comments WHERE video_id = :video ORDER BY id DESC", ['video' => $videoID]) -> fetchAll(PDO::FETCH_COLUMN);

    $commentsCount = count($comments);

    ?><div style="margin-left: 5%;margin-top: 5%; margin-bottom: 20%"><?php
        foreach($comments as $comment){
        $commentId = $db -> query("SELECT id FROM comments WHERE comment = :comment", ['comment' => $comment]) -> fetchColumn();
        $commentUploaderId = $db -> query("SELECT user_id FROM comments WHERE id = :id", ['id' => $commentId]) -> fetchColumn();
        $commentUploader = $db -> query("SELECT usernames FROM users WHERE id = :id", ['id' => $commentUploaderId]) -> fetchColumn();
        $profile_picture = $db->query("SELECT profile_pictures FROM users WHERE usernames = :username", ['username' => $commentUploader]) -> fetchColumn();
        $image_data = base64_encode($profile_picture);
        ?>
        <div id='commentContainer'>
            <a target="_top" style="text-decoration: none; color: black" href="<?="/Toni-Tok/HTML/partials/uploaderProfile.php?u_id=$commentUploaderId"?>"><div id='uploaderData' style='display: flex; align-items: center;'>
                <div id='commentPic' style="<?= "background-image: url('data:image/jpeg;base64,{$image_data}');" ?>"></div>
                <p id='commentUploader'><?= $commentUploader ?></p>
            </div></a>
            <p id='commentText'><?= $comment ?></p>
        </div>
    <?php }
    ?></div>

    <center><form method="POST" id="commentAddContainer">
        <textarea id='commentAddInput' type='text' placeholder="    Add comment..." data-title="<?= $title ?>"> </textarea>
        <button id='commentAddSubmit' data-title="<?= $title ?>"></button>
    </form></center>
<?php }else{
    echo("<p id='smtWentWrong'>We are sorry but something went wrong!</p>");
}
?>

<script>
    (function() {
        let commentButton = document.querySelector('#commentAddSubmit[data-title="<?= $title ?>"]');
        let commentInput = document.querySelector('#commentAddInput[data-title="<?= $title ?>"]');

        commentButton.addEventListener('click', function(event) { 
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/Toni-Tok/controllers/update_comments.php?title=<?= $title ?>&comments=<?= $commentsCount ?>&comment=' + encodeURIComponent(commentInput.value), true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('title=<?= $title ?>&comments=<?= $commentsCount ?>&comment=' + encodeURIComponent(commentInput.value));
        });

        commentInput.addEventListener('input', function() {
            if (commentInput.value.trim() !== '') {
                commentButton.style.display = 'block';                
                if(window.innerHeight >= 300){
                    commentInput.style.width = '80%';
                }else{
                    commentInput.style.width = '75%';
                }
            } else {
                commentButton.style.display = 'none';
                if(window.innerHeight >= 300){
                    commentInput.style.width = '94%';
                }else{
                    commentInput.style.width = '88%';
                }
                
            }
        });
    })();

    let commentsCount = <?= $commentsCount ?>;
    let body = document.body;

    if (commentsCount < 1) {
        body.style.backgroundImage = 'url(/Toni-Tok/HTML/images/NO-COMMENTS.png)';
        body.style.backgroundSize = '90%';
        body.style.backgroundRepeat = 'no-repeat';
        body.style.backgroundPositionX = 'center';
        if(window.innerHeight >= 300){
            body.style.backgroundPositionY = '40px';
        }else{
            body.style.backgroundPositionY = '20px';
        }
    }
</script>
</body>
</html>
