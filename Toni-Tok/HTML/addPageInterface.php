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
<?php require('partials/navigation.php') ?>

    <?php if(isset($_SESSION['user']['username'])){?>
            <form action="<?= "/Toni-Tok/controllers/formSubmition.php" ?>" id="postForm" method="POST">
                <label for="postTitle">Enter the title of the video:</label><br>
                <input autocomplete="off" type="text" id="postTitle" name="title"><br>
                <label for="postLink">Enter the link to the video:</label><br>
                <input autocomplete="off" placeholder="    The links are the part of the URL after the 'watch?v='" type="text" id="postLink" name="link"><br>
                <label for="postTag">Enter the tag/s of the video:</label><br>
                <input autocomplete="off" type="text" id="postTag" name="tag" placeholder="    Every tag must start with '#'"><br>
                <input type="submit" id="postSubmit" value="Submit"><br>
            </form>
    <?php }else{ ?>
        <p id='formError'>We are sorry but you can't add a video if you don't have an account.</p>
    <?php } ?>
            

</body>
</html>