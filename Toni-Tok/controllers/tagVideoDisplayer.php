<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_GET['tag'])){
    if(isset($_SESSION['user']) && $_SESSION['user'] != null){
        $root = $_SERVER['DOCUMENT_ROOT'];
        require_once("{$root}/Toni-Tok/Database.php");
        $db = new Database();
        $currentUser = $_SESSION['user']['username'];

        $tag = $_GET['tag'];
    
        $allTitles = $db->query("SELECT title FROM videos WHERE tag REGEXP '#{$tag}#*'")->fetchAll(PDO::FETCH_COLUMN);
    
        foreach ($allTitles as $title) {
            $videoId = $db->query("SELECT id FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $userID = $db->query("SELECT user_id FROM createdVideos WHERE video_id = :video", ['video' => $videoId])->fetchColumn();
            $uploader = $db->query("SELECT usernames FROM users WHERE id = :user", ['user' => $userID])->fetchColumn();
            $link = $db->query("SELECT link FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $likes = $db->query("SELECT likes FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $favourites = $db->query("SELECT favourites FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $allComments = $db->query("SELECT id FROM comments WHERE video_id = :video", ['video' => $videoId])->fetchAll(PDO::FETCH_COLUMN);
            $comments = count($allComments);
            $isLiked = "no";
            $everyTag = $db->query("SELECT tag FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $tags = explode("#", $everyTag);
            $tags = array_filter($tags);
    
            if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
                $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();
    
                $alreadyLiked = $db->query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);
    
                $isLiked = count($alreadyLiked) > 0 ? "yes" : "no";
            }
        ?>
    
    <center>
        <p id="videoTitles"><?= $title ?></p>
        <?php 
        foreach($tags as $tag){
            echo("<a id='videoTags' href='/Toni-Tok/HTML/partials/tags.php?tag={$tag}'>#{$tag}</a>");
        }
        ?>
                <p id="videoTitles" style="font-size: 2vw">Uploaded by: <a id="profileLinks" href="<?php if($uploader == $currentUser){echo("/Toni-Tok/controllers/profile.php");}else{echo("/Toni-Tok/HTML/partials/uploaderProfile.php?u_id=$userID");}?>">@<?= $uploader ?></a></p>
        <iframe class='videoDisplayer' src="https://www.youtube.com/embed/<?= $link ?>?playlist=<?= $link ?>&loop=1" allowfullscreen></iframe>
        <iframe name="hidden_iframe" id="hidden_iframe_<?= $title ?>" style="display:none;"></iframe>
        <form method='POST' action='' target="hidden_iframe_<?= $title ?>" class='videoControls'>
            <div>
                <button style="<?php echo $isLiked == 'yes' ? "background-image: url(/Toni-Tok/HTML/images/liked.png)" : ''?>" class="likeButton" data-title="<?= $title ?>"></button>
                <p class='likesCounter'><?= $likes ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
            <div>
                <button class="commentButton" data-title="<?= $title ?>"></button>
                <p class='commentCounter'><?= $comments ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
            <div>
                <button style="<?php echo $isFavourited == 'yes' ? "background-image: url(/Toni-Tok/HTML/images/favourited.png)" : ''?>" class="favouriteButton" data-title="<?= $title ?>"></button>
                <p class='favouriteCounter'><?= $favourites ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
        </form>
        <iframe class="commentSection" data-title="<?= $title ?>" src="/Toni-Tok/controllers/commentSection.php?title=<?= $title ?>"></iframe>
    </center>

    <script>
    (function() {
        let likeButton = document.querySelector('.likeButton[data-title="<?= $title ?>"]');
        let favouriteButton = document.querySelector('.favouriteButton[data-title="<?= $title ?>"]');
        let commentButton = document.querySelector('.commentButton[data-title="<?= $title ?>"]');
        let commentSection = document.querySelector('.commentSection[data-title="<?= $title ?>"]');
        isOpened = 'no';
        let isLiked = "<?php echo $isLiked; ?>";
        let likesCounter = likeButton.nextElementSibling;
        let isFavourited = "<?php echo $isFavourited; ?>";
        let favouriteCounter = favouriteButton.nextElementSibling;
        let commentCounter = commentButton.nextElementSibling;
        let xhr = new XMLHttpRequest();

        likeButton.addEventListener('click', function(event) {
            event.preventDefault();

            xhr.open('POST', '/Toni-Tok/controllers/update_likes.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('title=<?= $title ?>&likes=' + likesCounter.textContent);

            if (isLiked === "no") {
                likeButton.style.backgroundImage = 'url(/Toni-Tok/HTML/images/liked.png)';
                likesCounter.textContent = parseInt(likesCounter.textContent) + 1;
                isLiked = 'yes';
            } else {
                likeButton.style.backgroundImage = 'url(/Toni-Tok/HTML/images/unliked.png)';
                likesCounter.textContent = parseInt(likesCounter.textContent) - 1;
                isLiked = 'no';
            }
        });

        favouriteButton.addEventListener('click', function(event) {
            event.preventDefault();

            xhr.open('POST', '/Toni-Tok/controllers/update_favourites.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('title=<?= $title ?>&favourites=' + favouriteCounter.textContent);

            if (isFavourited === "no") {
                favouriteButton.style.backgroundImage = 'url(/Toni-Tok/HTML/images/favourited.png)';
                favouriteCounter.textContent = parseInt(favouriteCounter.textContent) + 1;
                isFavourited = 'yes';
            } else {
                favouriteButton.style.backgroundImage = 'url(/Toni-Tok/HTML/images/favourites.png)';
                favouriteCounter.textContent = parseInt(favouriteCounter.textContent) - 1;
                isFavourited = 'no';
            }
        });

        commentButton.addEventListener('click', function(event) {  
            event.preventDefault();

            if(isOpened == 'no'){
                commentSection.style.height = '30vw';
                commentSection.style.boxShadow = '0vw 1vw 1vw 1vw rgba(0, 0, 0, 0.2)';
                isOpened = 'yes';
            }else{
                commentSection.style.height = '0';
                commentSection.style.boxShadow = 'none';
                isOpened = 'no';
            }
        });
    })();
</script>
    <?php
    }
    
    
    
    
    
        
    }else{
        $root = $_SERVER['DOCUMENT_ROOT'];
        require_once("{$root}/Toni-Tok/Database.php");
        $db = new Database();
        
        $tag = $_GET['tag'];
    
        $allTitles = $db->query("SELECT title FROM videos WHERE tag REGEXP '#{$tag}#*'")->fetchAll(PDO::FETCH_COLUMN);
        
        foreach ($allTitles as $title) {
            $videoId = $db->query("SELECT id FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $userID = $db->query("SELECT user_id FROM createdVideos WHERE video_id = :video", ['video' => $videoId])->fetchColumn();
            $uploader = $db->query("SELECT usernames FROM users WHERE id = :user", ['user' => $userID])->fetchColumn();
            $link = $db->query("SELECT link FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $likes = $db->query("SELECT likes FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $favourites = $db->query("SELECT favourites FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $allComments = $db->query("SELECT id FROM comments WHERE video_id = :video", ['video' => $videoId])->fetchAll(PDO::FETCH_COLUMN);
            $comments = count($allComments);
            $isLiked = "no";
            $everyTag = $db->query("SELECT tag FROM videos WHERE title = :title", ['title' => $title])->fetchColumn();
            $tags = explode("#", $everyTag);
            $tags = array_filter($tags);
        
            if (isset($_SESSION['user']) && $_SESSION['user'] != null) {
                $userId = $db->query("SELECT id FROM users WHERE usernames = :username", ['username' => $_SESSION['user']['username']])->fetchColumn();
        
                $alreadyLiked = $db->query("SELECT like_id FROM likedVideos WHERE user_id = :user AND video_id = :video", ['user' => $userId, 'video' => $videoId])->fetchAll(PDO::FETCH_ASSOC);
        
                $isLiked = count($alreadyLiked) > 0 ? "yes" : "no";
            }
        ?>
        
        <center>
            <p id="videoTitles"><?= $title ?></p>
            <?php 
            foreach($tags as $tag){
                echo("<a id='videoTags' href='/Toni-Tok/HTML/partials/tags.php?tag={$tag}'>#{$tag}</a>");
            }
            ?>
            <p id="videoTitles" style="font-size: 2vw">Uploaded by: <a id="profileLinks" href="<?="/Toni-Tok/HTML/partials/uploaderProfile.php?u_id=$userID"?>">@<?= $uploader ?></a></p>
            <iframe class='videoDisplayer' src="https://www.youtube.com/embed/<?= $link ?>?playlist=<?= $link ?>&loop=1" allowfullscreen></iframe>
            <div class='videoControls'>
            <div>
                <a href="/Toni-Tok/HTML/partials/userNotLogged.php"><button style="<?php echo $isLiked == 'yes' ? "background-image: url(/Toni-Tok/HTML/images/liked.png)" : ''?>" class="likeButton" data-title="<?= $title ?>"></button></a>
                <p class='likesCounter'><?= $likes ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
            <div>
                <a href="/Toni-Tok/HTML/partials/userNotLogged.php"><button class="commentButton" data-title="<?= $title ?>"></button></a>
                <p class='commentCounter'><?= $comments ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
            <div>
                <a href="/Toni-Tok/HTML/partials/userNotLogged.php"><button style="<?php echo $isLiked == 'yes' ? "background-image: url(/Toni-Tok/HTML/images/favourited.png)" : ''?>" class="favouriteButton" data-title="<?= $title ?>"></button></a>
                <p class='favouriteCounter'><?= $favourites ?></p>
                <input type="hidden" name="title" value="<?= $title ?>">
            </div>
            </div>
        </center>
        <?php
        }
    }
}else{?>
    <p id='formSubmitted' style='font-size: 4vw'>We are sorry but something went wrong.</p>
    <center><a href='/Toni-Tok/controllers/discover.php'><button id='formGBbutton'>Go back</button></a></center>"
<?php } ?>   
