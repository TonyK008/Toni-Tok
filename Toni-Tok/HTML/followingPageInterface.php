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
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/form.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

    <?php

    require('partials/navigation.php');?>

    <?php if(isset($_SESSION['user']['username'])){
        require('partials/selectFollowVideo.php');
    }else{ ?>
        <p id='formError'>We are sorry but you can't see the videos of the users you follow if you don't have an account.</p>
    <?php } ?>

</body>
</html>