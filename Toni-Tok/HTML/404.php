<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php
        require('CSS/main.css'); 
        require('CSS/home.css');
        ?>
    </style>
</head>
<body>

    <p id="error404para">Sorry! Page not found.</p>
    <p id="error404link"><a id="error404link" href="<?= $_SERVER['DOCUMENT_ROOT'] . 'Toni-Tok/' ?>">Go back to home page.</a></p>

</body>
</html>