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
        
        ?>
    </style>
</head>
<body>

    <?php require('partials/navigation.php'); ?> 

    <form action="<?= "/Toni-Tok/controllers/logInFormSubmition.php" ?>" id='logInForm' method='POST' style="">
        <label for='username'>Username:</label><br>
        <input type='text' name='username' id='username' autocomplete="off"><br>
        <label for='password'>Password:</label><br>
        <div id="passwordGroup">
            <input type='password' name='password' id='password' autocomplete="off">
            <button type="button" id="togglePassword"></button><br>
        </div>
        <center><a id='logInLink' href='/Toni-Tok/controllers/signUp.php'>Oh you don't have an account? Click here to sign-up.</a></center><br><br>
        <input type='submit' id='postSubmit' value='Log In'><br>
    </form>

    <script><?php require("{$root}/Toni-Tok/JS/showPassword.js") ?></script>

</body>
</html>