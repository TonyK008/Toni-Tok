<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $root = $_SERVER['DOCUMENT_ROOT']; require "{$root}/Toni-Tok/HTML/partials/icon.php" ?>
    <title>Toni-Tok</title>
    <style>
        <?php

        require("{$root}/Toni-Tok/CSS/errors.css"); 
        ?>
    </style>
</head>
<body>

    <?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    require("{$root}/Toni-Tok/Database.php");
    require("{$root}/Toni-Tok/HTML/partials/loginFunction.php");

    $db = new Database();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $currentUser = '';

    $allUsers = $db -> query("SELECT usernames FROM users WHERE usernames = '$username'");
    $userPassword = $db -> query("SELECT passwords FROM users WHERE usernames = '$username'") -> fetchColumn();

    if ($currentUser == '' && $allUsers -> rowCount() > 0 && password_verify($password, $userPassword)) {
        $currentUser = $username;
        login($currentUser);
    } else {
        echo("<p id='formSubmitted' style='font-size: 4vw'>We are sorry but the entered username or password were wrong!</p>");
        echo("<center><a href='/Toni-Tok/controllers/logIn.php'><button id='formGBbutton'>Try again</button></a></center>");
    }
       
    ?>

</body>
</html>