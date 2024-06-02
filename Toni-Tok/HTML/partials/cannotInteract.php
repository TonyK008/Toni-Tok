<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
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
    <center><p id='smtWentWrong'>We are sorry but yu can't like and favourite this video because you are it's uploader.</p>
    <a href='/Toni-Tok/controllers/discover.php'><button id='formGBbutton'>Go back</button></a><center>
</body>
</html>