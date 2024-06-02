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
<body id="userNotLogged">
    <p id='formSubmitted' style='font-size: 4vw'>We are sorry but you haven't logged into your account!<br>Please log in or create a new one.</p>
    <center>
        <a href='/Toni-Tok/controllers/signUp.php' style="margin-right: 30px"><button id='formGBbutton'>Sign up</button></a>
        <a href='/Toni-Tok/controllers/logIn.php'><button id='formGBbutton'>Log in</button></a>
    </center>
</body>
</html>