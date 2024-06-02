<?php 

function pageURL($value){
    $url_parts = parse_url($_SERVER['REQUEST_URI']);
    $path = $url_parts['path'];
    return $path === $value;
}

?>

<style>
<?php
    if(isset($_SESSION['user']) && $_SESSION['user'] != null){
        ?>
        .profileButton:hover #dropdownContent {
            height: 20vw;
            box-shadow: 0vw 1vw 2vw 1vw rgba(0, 0, 0, 0.2);
            transition: height 0.4s ease-in;
        }

        @media (max-width: 1000px){
            .profileButton:hover #dropdownContent {
                height: 30vw;
                max-height: 225px;
            }
        }

        @media (max-height: 900px){
            .profileButton:hover #dropdownContent {
                height: 50vh;
            }
        }<?php
    } else {
        require("userNotLoggedCSS.php");
    }
?>
</style>

<nav id="navigation">
    <a href="<?="/Toni-Tok/" ?>"><button style="<?= pageURL("/Toni-Tok/") ? 'background-color: rgb(37, 37, 37); color: white' : '' ?>" class="navButtons">Discover</button></a>
    <a href="<?= "/Toni-Tok/controllers/following.php" ?>"><button style="<?= pageURL("/Toni-Tok/controllers/following.php") ? 'background-color: rgb(37, 37, 37); color: white' : '' ?>" class="navButtons">Following</button></a> 
    <a href="<?= "/Toni-Tok/controllers/add.php" ?>"><button style="<?= pageURL("/Toni-Tok/controllers/add.php") || pageURL("/Toni-Tok/controllers/formSubmition.php") ? 'background-color: rgb(37, 37, 37); color: white' : '' ?>" class="navButtons">Add</button></a>
    
    <div class='profileButton' style="<?= (pageURL("/Toni-Tok/controllers/signUp.php") || pageURL("/Toni-Tok/controllers/logIn.php") || pageURL("/Toni-Tok/controllers/profile.php") ? 'box-shadow: 0px 0px 10px 10px rgba(255, 255, 255, 0.2);' : '')?>

    <?php
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
        }

    ?>">

        <div id="dropdownContent" style="
        <?php 
            if(!isset($_SESSION['user'])){
                echo("max-height: 80px");
            }
        ?>
        ">

        <?php
        if(isset($_SESSION['user']) && $_SESSION['user'] != null){
            echo("
                <a href='/Toni-Tok/controllers/profile.php'>Profile</a>
                <a href=''>Settings</a>
            ");
        } else{

        } ?>  
        
        <a href="
        <?php
        
            if(isset($_SESSION['user']) && $_SESSION['user'] != null){
                echo("/Toni-Tok/HTML/partials/logOut.php");
            } else{
                echo("/Toni-Tok/controllers/logIn.php");
            }
        
        ?>">

        <?php
            
        if(isset($_SESSION['user']) && $_SESSION['user'] != null){
            echo("Log out");
        }else{
            echo("Log in");
        } 
            
        ?>

        </a>
    </div>
    </div>
</nav>