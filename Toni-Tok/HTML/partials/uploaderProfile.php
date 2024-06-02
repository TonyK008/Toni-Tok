<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        if(!isset($_SESSION)){
            session_start();
        };        
        $root = $_SERVER['DOCUMENT_ROOT'];
        require "{$root}/Toni-Tok/HTML/partials/icon.php"
    ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        require_once("{$root}/Toni-Tok/Database.php");
        ?>
    </style>
</head>
<body>
    <?php require('navigation.php');

    $db = new Database();

    if(isset($_SESSION) && $_SESSION != null){
    if(isset($_GET['u_id'])) {
        $userID = $_GET['u_id'];
        $currentUser = $_SESSION['user']['username'];
        $uploaderUsername = $db -> query("SELECT usernames FROM users WHERE id = :userID", [
            'userID' => $userID
        ]) -> fetchColumn();
        $userId = $db -> query("SELECT id FROM users WHERE usernames = :user", ['user' => $currentUser]) -> fetchColumn();
        $alreadyFollowing =  "no";
        $following = $db -> query("SELECT id FROM followed WHERE user_id = $userID AND follower_id = $userId") -> fetchAll(PDO::FETCH_COLUMN);
        if(count($following) > 0){
            $alreadyFollowing = "yes";
        }
        ?>

            <div id="profilePicture" style="
            <?php
                $result = $db->query("SELECT * FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchAll(PDO::FETCH_ASSOC);
                if(count($result) > 0){
                    $profile_picture = $db->query("SELECT profile_pictures FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchColumn();
                    $image_data = base64_encode($profile_picture);

                    echo("background-image: url('data:image/jpeg;base64,{$image_data}')");

                }
            ?>">
            </div>
            <center><p id="usernameLabel"><?= $uploaderUsername ?></p></center>

            <center><form method=""><button id='followButton'><?php if($alreadyFollowing == "no"){echo("Follow");}else{echo("Following");}; ?></button></form></center>
    
            <hr>

            <div id='profileControlsContainer' style="grid-template-columns: 1fr">
            
                <center><a><button class='profileControls' id='allVideosControl' style="background-image: url(/Toni-Tok/HTML/images/allVideosAfter.png);"></button></a></center>
        
            </div>

            <div id="likedVideosContainer">
            <?php
                $userId = $db -> query("SELECT id FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchColumn();

                $allVideos = $db -> query("SELECT video_id FROM createdVideos WHERE user_id = :userID", [
                    'userID' => $userID
                ]) -> fetchAll(PDO::FETCH_COLUMN);

                foreach($allVideos as $Video){
                    $video_id = $db -> query("SELECT id FROM videos WHERE id = :video_id", [
                        'video_id' => $Video
                    ]) -> fetchColumn();
                    require("currentVideo.php");
                }
                ?>
            </div>

            <script>
                let followButton = document.querySelector("#followButton");
                let alreadyFollowing = "<?= $alreadyFollowing ?>";
                let xhr = new XMLHttpRequest();

                function changeButtonText() {
                    if (alreadyFollowing === 'no') {
                        followButton.textContent = "Following";
                        alreadyFollowing = 'yes';
                    } else {
                        followButton.textContent = "Follow";
                        alreadyFollowing = 'no';
                    }
                }

                followButton.addEventListener('click', function(event){
                    event.preventDefault();

                    xhr.open('POST', '/Toni-Tok/HTML/partials/update_followers.php?follower=<?= $currentUser ?>&following=<?= $userID ?>', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('follower=<?= $currentUser ?>&following=<?= $userID ?>');

                    changeButtonText();
                });

                followButton.addEventListener('mouseover', function(){
                    if (alreadyFollowing === 'yes') {
                        followButton.textContent = "Unfollow";
                    }
                });

                followButton.addEventListener('mouseout', function(){
                    if (alreadyFollowing === 'yes') {
                        followButton.textContent = "Following";
                    }
                });

            </script>

</body>
</html>
    <?php
    } else {?>
        <p id='formError'>We are sorry but something went wrong.</p>
    <?php }


}else{
    if(isset($_GET['u_id'])) {
        $userID = $_GET['u_id'];
        $uploaderUsername = $db -> query("SELECT usernames FROM users WHERE id = :userID", [
            'userID' => $userID
        ]) -> fetchColumn();
        ?>

            <div id="profilePicture" style="
            <?php
                $result = $db->query("SELECT * FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchAll(PDO::FETCH_ASSOC);
                if(count($result) > 0){
                    $profile_picture = $db->query("SELECT profile_pictures FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchColumn();
                    $image_data = base64_encode($profile_picture);

                    echo("background-image: url('data:image/jpeg;base64,{$image_data}')");

                }
            ?>">
            </div>
            <center><p id="usernameLabel"><?= $uploaderUsername ?></p></center>

            <center><a href="/Toni-Tok/HTML/partials/userNotLogged.php"><button id='followButton'>Follow</button></a></center>
    
            <hr>

            <div id='profileControlsContainer' style="grid-template-columns: 1fr">
            
                <center><a><button class='profileControls' id='allVideosControl' style="background-image: url(/Toni-Tok/HTML/images/allVideosAfter.png);"></button></a></center>
        
            </div>

            <div id="likedVideosContainer">
            <?php
                $userId = $db -> query("SELECT id FROM users WHERE usernames = :uploaderUsername", ['uploaderUsername' => $uploaderUsername]) -> fetchColumn();

                $allVideos = $db -> query("SELECT video_id FROM createdVideos WHERE user_id = :userID", [
                    'userID' => $userID
                ]) -> fetchAll(PDO::FETCH_COLUMN);

                foreach($allVideos as $Video){
                    $video_id = $db -> query("SELECT id FROM videos WHERE id = :video_id", [
                        'video_id' => $Video
                    ]) -> fetchColumn();
                    require("currentVideo.php");
                }
                ?>
            </div>
            </body>
</html>
    <?php
    } else {?>
        <p id='formError'>We are sorry but something went wrong.</p>
    <?php }
}