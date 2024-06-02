<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        $root = $_SERVER['DOCUMENT_ROOT'];
        $db = new Database();
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/form.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>
<?php

    if(isset($_GET['search'])){
        
        if(isset($_SESSION['user']['username'])){
            $currentUser = $_SESSION['user']['username'];
            $userId = $db -> query("SELECT id FROM users WHERE usernames = :username", ['username' => $currentUser]) -> fetchColumn();
        }else{
            $userId = null;
        }
        
        $searching = $_GET['search'];

        $searchedUserID = $db -> query("SELECT id FROM users WHERE usernames LIKE '%{$searching}%'") -> fetchColumn();
        $searches = $db -> query("SELECT video_id FROM createdVideos WHERE user_id = '{$searchedUserID}'") -> fetchAll(PDO::FETCH_COLUMN);

        require('partials/navigation.php');?>

    <center>
    <div id='searchContainer'>
        <input id='searchInput' type='text' autocomplete='off'>
        <input type="submit" id='searchButton' value=''>
    </div>
    </center>

        <div id='searchPageControls'>
            <a href=<?= "/Toni-Tok/controllers/searchTitle.php?search={$searching}" ?>><button id='titleSearchControl'>title</button></a>
            <a href=<?= "/Toni-Tok/controllers/searchTag.php?search={$searching}" ?>><button id='tagSearchControl'>tag</button></a>
            <button id='uploaderSearchControl' style="<?= pageURL("/Toni-Tok/controllers/searchUploader.php") ? 'color: #444444; border: none; cursor: pointer; font-size: 2vw ' : '' ?>">uploader</button>
        </div>

        <hr style="background-color: #8888; border: none">

        <div id='searchVideosContainer'><?php
            foreach($searches as $search){
            $video_id = $db -> query("SELECT id FROM videos WHERE id = :video", [
                'video' => $search
            ]) -> fetchColumn();
            require("partials/uploaderSearchCurrentVideo.php");
        }
        ?></div>

        <script>
            let searchButton = document.querySelector('#searchButton');
            let searchInput = document.querySelector('#searchInput');

            searchButton.addEventListener('click', function(){
                let search = searchInput.value.trim();
                if(search !== ''){
                    window.location.href = `/Toni-Tok/controllers/searchUploader.php?search=${search}`;
                } else {
                    window.location.href = '/Toni-Tok/';
                }
            });
        </script><?php
    }else{?>
        <p id='formSubmitted' style='font-size: 4vw'>We are sorry but something went wrong.</p>
        <center><a href='/Toni-Tok/controllers/discover.php'><button id='formGBbutton'>Go back</button></a></center>"
    <?php } ?>    

</body>
</html>