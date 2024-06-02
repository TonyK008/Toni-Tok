<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php session_start();$root = $_SERVER['DOCUMENT_ROOT']; require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require("{$root}/Toni-Tok/CSS/main.css"); 
        require("{$root}/Toni-Tok/CSS/form.css"); 
        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

    <?php
    require_once("{$root}/Toni-Tok/Database.php");

    $db = new Database();

    require('navigation.php');
    require('selectTagVideo.php');

    ?>

</body>
</html>