<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $root = $_SERVER['DOCUMENT_ROOT']; require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

    <?php
        require_once("{$root}/Toni-Tok/Database.php");
        require('partials/navigation.php');
    ?>

    <?php 

    $db = new Database();

    $allUsers = $db -> query("SELECT title FROM videos WHERE title = :title", [
        'title' => $_POST['title']
    ]);

    if ($allUsers->rowCount() > 0) {
        echo "<p id='formSubmitted' style='font-size: 4vw'>We are sorry but a video with this title already exists!<br>Please choose another one.</p>";
        echo "<center><a href='/Toni-Tok/controllers/add.php'><button id='formGBbutton'>Go back</button></a></center>";
    }else{
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<p id='formSubmitted'>You submitted the form successfully</p>";
        echo "<center><a href='/Toni-Tok/controllers/add.php'><button id='formGBbutton'>Go back</button></a></center>";
        require("partials/saveVideo.php");
        } else {
            echo "<p id='formError'>We are sorry but something went wrong.</p>";
            echo "<center><a href='/Toni-Tok/controllers/add.php'><button id='formGBbutton'>Go back</button></a></center>";
        }
    }      
    ?>
</body>
</html>